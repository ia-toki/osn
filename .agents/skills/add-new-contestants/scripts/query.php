<?php
/**
 * Ad-hoc read-only query runner. There is no `mysql` CLI on this machine, so use this instead.
 *
 *   php .agents/skills/add-new-contestants/scripts/query.php "SELECT Name FROM School WHERE Name LIKE '%Sutomo%'"
 *
 * Prints tab-separated rows. Credentials come from .env (database.default.*).
 */

require __DIR__ . '/db.php';

$sql = $argv[1] ?? null;
if ($sql === null) {
    fwrite(STDERR, "usage: php query.php \"<SQL>\"\n");
    exit(1);
}
if (preg_match('/^\s*(insert|update|delete|drop|alter|truncate|create|replace)\b/i', $sql)) {
    fwrite(STDERR, "refusing to run a write statement; this skill never modifies the database\n");
    exit(1);
}

$db = connectDb();
$result = $db->query($sql);
if ($result === false) {
    fwrite(STDERR, $db->error . "\n");
    exit(1);
}
while ($row = $result->fetch_assoc()) {
    echo implode("\t", array_map(fn ($v) => $v === null ? 'NULL' : $v, $row)), "\n";
}
