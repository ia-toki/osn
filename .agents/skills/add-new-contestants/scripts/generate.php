<?php
/**
 * Turns a raw contestant CSV into a cleaned CSV plus the SQL needed to load it.
 *
 *   php .agents/skills/add-new-contestants/scripts/generate.php <config.json>
 *
 * Writes three files next to the configured output prefix and then verifies the SQL by
 * applying it inside a transaction that is always rolled back. The database is never modified.
 *
 * Config keys:
 *   source        (required) path to the raw CSV, relative to the project root
 *   competition   (required) Competition.ID, e.g. "OSN2025"
 *   outputPrefix  (required) e.g. "data/osn2025" -> data/osn2025_clean.csv, _person_school.sql, _contestant.sql
 *   schools       (required) map of every distinct raw CSV school value => DB-style name
 *   teamNo        (optional) Contestant.TeamNo for every row: 1 = official (default), 2 = host
 *                 country's guest team, 3 = semifinalist. Use 3 for a whole semifinalist list.
 *   teamNoMap     (optional) use when one CSV mixes cohorts: add a "teamNo" entry to `columns`
 *                 pointing at the marker column, then map each distinct value (lowercased,
 *                 trimmed; "" for blank) to a TeamNo, e.g. {"": 1, "semifinalist": 3}. This keeps
 *                 both cohorts in one run so their new Person/School IDs cannot collide.
 *   columns       (optional) zero-based column indices, default {"name":0,"gender":1,"grade":2,"school":3,"province":4}
 */

require __DIR__ . '/db.php';

// ---------------------------------------------------------------- config

$configPath = $argv[1] ?? null;
if ($configPath === null) {
    fwrite(STDERR, "usage: php generate.php <config.json>\n");
    exit(1);
}
$config = json_decode(file_get_contents($configPath), true);
if (!is_array($config)) {
    fwrite(STDERR, "cannot parse $configPath as JSON\n");
    exit(1);
}
foreach (['source', 'competition', 'outputPrefix', 'schools'] as $key) {
    if (!isset($config[$key])) {
        fwrite(STDERR, "config is missing required key: $key\n");
        exit(1);
    }
}
$root         = projectRoot();
$sourcePath   = $config['source'][0] === '/' ? $config['source'] : "$root/{$config['source']}";
$outputPrefix = $config['outputPrefix'][0] === '/' ? $config['outputPrefix'] : "$root/{$config['outputPrefix']}";
$competition  = $config['competition'];
$teamNo       = (int)($config['teamNo'] ?? 1);
if (!in_array($teamNo, [1, 2, 3], true)) {
    fwrite(STDERR, "teamNo must be 1 (official), 2 (host guest team) or 3 (semifinalist)\n");
    exit(1);
}
$columns      = ($config['columns'] ?? []) + ['name' => 0, 'gender' => 1, 'grade' => 2, 'school' => 3, 'province' => 4];
$schoolMap    = $config['schools'];
$teamNoColumn = $columns['teamNo'] ?? null;
$teamNoMap    = [];
foreach (($config['teamNoMap'] ?? []) as $marker => $value) {
    $teamNoMap[mb_strtolower(trim((string)$marker))] = (int)$value;
}
if ($teamNoColumn !== null && !$teamNoMap) {
    fwrite(STDERR, "columns.teamNo needs a teamNoMap saying what each marker value means\n");
    exit(1);
}

// ---------------------------------------------------------------- normalization

/** Title Case, the way Person.Name is stored: "MUHAMMAD AL FATIH" => "Muhammad Al Fatih". */
function titleCase(string $value): string {
    $value = preg_replace('/\s+/u', ' ', trim($value));
    return preg_replace_callback('/[\p{L}\p{N}\'’.-]+/u', function ($match) {
        $parts = preg_split('/([-\'’])/u', $match[0], -1, PREG_SPLIT_DELIM_CAPTURE);
        $word = '';
        foreach ($parts as $part) {
            if ($part === '' || preg_match('/^[-\'’]$/u', $part)) {
                $word .= $part;
                continue;
            }
            $word .= mb_strtoupper(mb_substr($part, 0, 1)) . mb_strtolower(mb_substr($part, 1));
        }
        return $word;
    }, $value);
}

/** Raw CSV province ("Prov. D.K.I. Jakarta") => the form stored in Province.Name ("DKI Jakarta"). */
function provinceKey(string $value): string {
    $value = trim(preg_replace('/^Prov\.\s*/iu', '', trim($value)));
    // Case-insensitive: raw lists arrive both as "Prov. Kepulauan Riau" and "PROV. KEPULAUAN RIAU".
    $value = preg_replace(['/D\.K\.I\./iu', '/D\.I\./iu', '/Kepulauan/iu'], ['DKI', 'D. I.', 'Kep.'], $value);
    return mb_strtolower(preg_replace('/\s+/u', ' ', $value));
}

/** Token overlap, used only to warn about near-duplicate people. */
function similarity(string $a, string $b): float {
    $tokenize = fn ($s) => array_filter(explode(' ', mb_strtolower(preg_replace('/[^\p{L}\p{N} ]/u', '', $s))));
    $ta = $tokenize($a);
    $tb = $tokenize($b);
    $union = count(array_unique(array_merge($ta, $tb)));
    return $union === 0 ? 0.0 : count(array_intersect($ta, $tb)) / $union;
}

// ---------------------------------------------------------------- existing data

$db = connectDb();

$provinceIdByName = [];
$result = $db->query('SELECT ID, Name FROM Province');
while ($row = $result->fetch_assoc()) {
    $provinceIdByName[mb_strtolower($row['Name'])] = $row['ID'];
}

$schoolIdByName = [];
$result = $db->query('SELECT ID, Name FROM School');
while ($row = $result->fetch_assoc()) {
    $schoolIdByName[mb_strtolower($row['Name'])] = (int)$row['ID'];
}

$personIdByName = [];
$allPersons = [];
$result = $db->query('SELECT ID, Name FROM Person');
while ($row = $result->fetch_assoc()) {
    $personIdByName[mb_strtolower($row['Name'])] = (int)$row['ID'];
    $allPersons[(int)$row['ID']] = $row['Name'];
}

// information_schema.TABLES.AUTO_INCREMENT is cached and can lag; MAX(ID) is authoritative.
$nextPersonId     = (int)$db->query('SELECT MAX(ID) x FROM Person')->fetch_assoc()['x'] + 1;
$nextSchoolId     = (int)$db->query('SELECT MAX(ID) x FROM School')->fetch_assoc()['x'] + 1;
$nextContestantId = (int)$db->query('SELECT MAX(ID) x FROM Contestant')->fetch_assoc()['x'] + 1;

$competitionExists = (int)$db->query(sprintf(
    "SELECT COUNT(*) c FROM Competition WHERE ID = '%s'",
    $db->real_escape_string($competition)
))->fetch_assoc()['c'];
if (!$competitionExists) {
    fwrite(STDERR, "no Competition row with ID '$competition'; create it first\n");
    exit(1);
}

// Contestant has UNIQUE (Competition, Person), so anyone already entered would collide.
$alreadyEntered = [];
$result = $db->query(sprintf(
    "SELECT Person FROM Contestant WHERE Competition = '%s'",
    $db->real_escape_string($competition)
));
while ($row = $result->fetch_assoc()) {
    $alreadyEntered[(int)$row['Person']] = true;
}

// ---------------------------------------------------------------- process rows

$handle = fopen($sourcePath, 'r');
if ($handle === false) {
    fwrite(STDERR, "cannot read $sourcePath\n");
    exit(1);
}
fgetcsv($handle); // header

$rows = [];
$newPersons = [];
$newSchools = [];
$warnings = [];
$errors = [];
$lineNo = 1;

while (($record = fgetcsv($handle)) !== false) {
    $lineNo++;
    if (count(array_filter($record, fn ($v) => trim((string)$v) !== '')) === 0) {
        continue;
    }

    $name   = titleCase($record[$columns['name']]);
    $gender = mb_strtoupper(trim($record[$columns['gender']]));
    $grade  = (int)trim($record[$columns['grade']]);
    $rawSchool = trim($record[$columns['school']]);
    $rawProvince = trim($record[$columns['province']]);

    if (!in_array($gender, ['L', 'P'], true)) {
        $errors[] = "line $lineNo: gender '$gender' is neither L nor P";
    }

    $rowTeamNo = $teamNo;
    if ($teamNoColumn !== null) {
        $marker = mb_strtolower(trim((string)($record[$teamNoColumn] ?? '')));
        if (!array_key_exists($marker, $teamNoMap)) {
            $errors[] = "line $lineNo: teamNoMap has no entry for marker \"$marker\"";
            continue;
        }
        $rowTeamNo = $teamNoMap[$marker];
    }

    // Person
    $personId = $personIdByName[mb_strtolower($name)] ?? null;
    if ($personId === null) {
        foreach ($allPersons as $id => $existing) {
            $score = similarity($name, $existing);
            if ($score >= 0.6 && $score < 1.0) {
                $warnings[] = sprintf('line %d: "%s" looks close to existing Person %d "%s" (%.0f%% token overlap)', $lineNo, $name, $id, $existing, $score * 100);
            }
        }
        $personId = $nextPersonId++;
        $personIdByName[mb_strtolower($name)] = $personId;
        $allPersons[$personId] = $name;
        $newPersons[$personId] = $name;
    } elseif (isset($alreadyEntered[$personId])) {
        $errors[] = "line $lineNo: \"$name\" (Person $personId) already has a $competition Contestant row; the CSV may have been loaded already";
    }

    // School
    if (!array_key_exists($rawSchool, $schoolMap)) {
        $errors[] = "line $lineNo: no mapping for school \"$rawSchool\"";
        continue;
    }
    $schoolName = $schoolMap[$rawSchool];
    $schoolId = $schoolIdByName[mb_strtolower($schoolName)] ?? null;
    if ($schoolId === null) {
        $schoolId = $nextSchoolId++;
        $schoolIdByName[mb_strtolower($schoolName)] = $schoolId;
        $newSchools[$schoolId] = $schoolName;
    }

    // Province
    $key = provinceKey($rawProvince);
    if (!isset($provinceIdByName[$key])) {
        $errors[] = "line $lineNo: no Province row matching \"$rawProvince\"";
        continue;
    }
    $provinceId = $provinceIdByName[$key];

    $rows[] = [$name, $gender, $grade, $schoolName, $provinceId, $personId, $schoolId, $rowTeamNo];
}
fclose($handle);

if ($errors) {
    fwrite(STDERR, "resolve these before anything is written:\n  " . implode("\n  ", $errors) . "\n");
    exit(1);
}

// ---------------------------------------------------------------- write outputs

$cleanPath      = $outputPrefix . '_clean.csv';
$personSqlPath  = $outputPrefix . '_person_school.sql';
$contestantPath = $outputPrefix . '_contestant.sql';

$out = fopen($cleanPath, 'w');
fputcsv($out, ['Nama', 'J/K', 'Kelas', 'Sekolah', 'Provinsi', 'PersonID', 'SchoolID', 'TeamNo']);
foreach ($rows as $row) {
    fputcsv($out, $row);
}
fclose($out);

$quote = fn ($value) => "'" . str_replace("'", "''", $value) . "'";
$sourceLabel = basename($sourcePath);

$sql  = "-- New Person and School rows for $sourceLabel.\n";
$sql .= "-- IDs are explicit, continuing from MAX(ID) of each table at generation time.\n\n";
if ($newPersons) {
    $values = [];
    foreach ($newPersons as $id => $name) {
        $values[] = sprintf('(%d, %s)', $id, $quote($name));
    }
    $sql .= "INSERT INTO `Person` (`ID`, `Name`) VALUES\n" . implode(",\n", $values) . ";\n\n";
} else {
    $sql .= "-- No new people.\n\n";
}
if ($newSchools) {
    $values = [];
    foreach ($newSchools as $id => $name) {
        $values[] = sprintf('(%d, %s)', $id, $quote($name));
    }
    $sql .= "INSERT INTO `School` (`ID`, `Name`) VALUES\n" . implode(",\n", $values) . ";\n";
} else {
    $sql .= "-- No new schools.\n";
}
file_put_contents($personSqlPath, $sql);

$sql  = "-- Contestant rows for $competition from $sourceLabel.\n";
$sql .= "-- Run AFTER " . basename($personSqlPath) . " (Person and School rows must exist first).\n";
$sql .= "-- Score, ScoreMark, Rank and Medal are left NULL: the source CSV carries no results.\n";
$teamNosUsed = array_unique(array_column($rows, 7));
if (in_array(3, $teamNosUsed, true)) {
    $sql .= "-- TeamNo 3 marks a contestant as a semifinalist: the site keeps them out of every\n";
    $sql .= "-- medal and participant tally, blanks their rank, and merges their task cells into a\n";
    $sql .= "-- \"Semifinalis\" label.\n";
}
$sql .= "\n";
$sql .= "INSERT INTO `Contestant` (`ID`, `Competition`, `Person`, `School`, `Province`, `Gender`, `Grade`, `TeamNo`) VALUES\n";
$values = [];
foreach ($rows as $row) {
    [, $gender, $grade, , $provinceId, $personId, $schoolId, $rowTeamNo] = $row;
    $values[] = sprintf('(%d, %s, %d, %d, %s, %s, %d, %d)',
        $nextContestantId++, $quote($competition), $personId, $schoolId, $quote($provinceId), $quote($gender), $grade, $rowTeamNo);
}
$sql .= implode(",\n", $values) . ";\n";
file_put_contents($contestantPath, $sql);

// ---------------------------------------------------------------- verify, then roll back

$db->begin_transaction();
$applied = true;
try {
    foreach ([$personSqlPath, $contestantPath] as $path) {
        $db->multi_query(file_get_contents($path));
        do {
            if ($result = $db->store_result()) {
                $result->free();
            }
        } while ($db->more_results() && $db->next_result());
        if ($db->errno) {
            throw new RuntimeException($db->error);
        }
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'dry run failed: ' . $e->getMessage() . "\n");
    $applied = false;
}
$db->rollback();

foreach ($warnings as $warning) {
    fwrite(STDERR, "warning: $warning\n");
}

$byTeamNo = array_count_values(array_column($rows, 7));
ksort($byTeamNo);
$teamNoSummary = [];
foreach ($byTeamNo as $no => $count) {
    $teamNoSummary[] = "teamNo$no=$count";
}
printf("contestants=%d (%s) newPersons=%d newSchools=%d reusedPersons=%d\n",
    count($rows), implode(' ', $teamNoSummary), count($newPersons), count($newSchools), count($rows) - count($newPersons));
printf("wrote %s\n      %s\n      %s\n", $cleanPath, $personSqlPath, $contestantPath);
echo $applied ? "dry run applied cleanly and was rolled back; database unchanged\n" : "DRY RUN FAILED, see above\n";
exit($applied ? 0 : 1);
