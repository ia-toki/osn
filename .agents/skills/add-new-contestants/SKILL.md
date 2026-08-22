---
name: add-new-contestants
description: Prepare a raw contestant CSV (nama, J/K, kelas, sekolah, provinsi) for insertion into the osn database — normalize names, schools and provinces to house conventions, then emit a cleaned CSV plus SQL for the new Person, School and Contestant rows. Use when asked to load, clean, import or prepare a contestant list for a competition.
---

Turn a raw contestant list into reviewable SQL. **Produce files only — never write to the database.** The user runs the SQL themselves after reading it.

## Inputs

- A raw CSV, usually `data/<competition>.csv`, with the header `Nama,J/K,Kelas,Sekolah,Provinsi`. Values arrive inconsistent: names in ALL CAPS or mixed case, schools in Dapodik form (`SMA NEGERI 2 TENGGARONG`, `SMAS KATOLIK RAJAWALI`), provinces prefixed with `Prov. `.
- The `Competition.ID` these contestants belong to (e.g. `OSN2025`). It must already exist in the DB.

## Outputs

Three files sharing one prefix, e.g. for `data/osn2025`:

| File | Contents |
| --- | --- |
| `_clean.csv` | reformatted rows plus resolved `PersonID` / `SchoolID` columns |
| `_person_school.sql` | `INSERT` for people and schools not yet in the DB |
| `_contestant.sql` | `INSERT` for the `Contestant` rows |

Leave the original CSV untouched.

## Database access

There is **no `mysql` client** on this machine. Query through the bundled helper, which reads credentials from `.env`:

```
php .agents/skills/add-new-contestants/scripts/query.php "SELECT ID, Name FROM School WHERE Name LIKE '%Sutomo%'"
```

Schema facts that matter:

- `Person.Name` — `varchar(100)`, no unique key, so duplicates are possible and must be prevented by checking.
- `School.Name` — `varchar(250)`, **`UNIQUE`**.
- `Contestant.Province` — `char(3)` FK to `Province.ID` (`JKZ`, `JIZ`, `PBD`…), not a province name.
- `Contestant` — `UNIQUE (Competition, Person)`; a person may appear in many competitions but only once each.
- `Contestant.Grade` is an int, `Gender` is `L` or `P`.
- `Contestant.TeamNo` is how a row counts: `1` official, `2` host guest team, `3` semifinalist. Only `TeamNo = 1` rows appear in the statistics aggregations.

## Step 1 — normalize the values

**Names → Title Case.** Every row in `Person` is Title Case; there are no ALL-CAPS tokens. Particles stay capitalized as ordinary words (`Hayyan Ahmad Al Ghifary`, `Uny Madya Binti Wasio`). `scripts/generate.php` does this automatically.

**Provinces → `Province.ID`.** Drop the `Prov. ` prefix, then match `Province.Name`: `D.K.I. Jakarta` → `DKI Jakarta` → `JKZ`, `D.I. Yogyakarta` → `D. I. Yogyakarta` → `YOZ`, `Kepulauan Riau` → `Kep. Riau` → `KRZ`, `Luar Negeri` → `LNZ`. Handled automatically; an unmatched province is a hard error.

**Schools → house style.** This is the judgment-heavy part and is *not* automatic — you build the mapping. Conventions read off the existing `School` rows:

- `SMA Negeri N X` / `SMAN N X` → **`SMAN N X`**; drop `Negeri` and `Swasta` (`SMA NEGERI 2 TENGGARONG` → `SMAN 2 Tenggarong`, `SMAS SUTOMO 1` → `SMA Sutomo 1 Medan`).
- Catholic/Christian schools collapse the word into the prefix: `SMAS KATOLIK RAJAWALI` → **`SMAK Rajawali Makassar`**, `SMAS KRISTEN EBEN HAEZAR` → `SMAK Eben Haezar`. Same for `SMPK`.
- `Santo` / `Saint` → **`St.`** (`SMA St. Thomas 1 Medan`). `Wr.` for `Wage Rudolf`.
- `Al `/`Ar `/`As ` prefixes are hyphenated: **`Al-Irsyad`**, `Al-Azhar`, `Ar-Rohmah`, `As-Syifa`.
- Everything after the prefix is Title Case; acronym-style names keep their caps (`BPK PENABUR`, `IPEKA`, `MTA`, `YPPK`).
- **State schools always carry the city or kabupaten** — the name is otherwise just a number: `SMAN 1 Padang`, `MAN 1 Barito Kuala`, `MAN Insan Cendekia Kota Palangka Raya`. Use `Kab.` when the kabupaten must be distinguished from the kota (`SMAN 2 Kab. Sorong` vs the existing `SMAN 2 Sorong`).
- **New private schools get no city suffix** unless an existing DB row would otherwise be ambiguous: `SMP Bustanul Makmur`, `SMA Mutiara Harapan`. Only add the city to tell two schools apart.
- **A one-word name may keep its city.** If dropping the city would leave a single word after the level prefix — `SMA Averos Sorong`, `SMAK Rajawali Makassar`, `SMP YPPI Perawang` — the name is thin enough that the city still earns its place. Both forms are correct here: the DB holds `SMA Mondial Batam` next to `SMA Dyatmika`, and neither is an inconsistency to "fix". Drop the city only when what remains stands on its own.

## Step 2 — resolve each school against the DB

For every distinct raw school value, search before deciding it is new:

```
php .agents/skills/add-new-contestants/scripts/query.php "SELECT ID, Name FROM School WHERE Name LIKE '%Maitreyawira%'"
```

Search a distinctive word, not the whole string — the raw form rarely matches the stored form. Reuse the existing row whenever it is the same school. When the raw name is ambiguous or you cannot tell which city it belongs to, look it up on the web (Dapodik pages are authoritative for the kecamatan/kota) rather than guessing, and tell the user which mappings you were unsure about.

Watch for genuinely different schools with near-identical names — `SMAN 2 Sorong` (kota) and `SMAN 2 Kab. Sorong` are two schools; `SMAS Maitreyawira` exists in both Batam and Tanjungpinang.

## Step 3 — generate

Write a config JSON (anywhere temporary) with a mapping entry for **every** distinct raw school value:

```json
{
  "source": "data/osn2025.csv",
  "competition": "OSN2025",
  "outputPrefix": "data/osn2025",
  "schools": {
    "SMA NEGERI 2 TENGGARONG": "SMAN 2 Tenggarong",
    "SMAS KATOLIK RAJAWALI": "SMAK Rajawali Makassar"
  }
}
```

Then:

```
php .agents/skills/add-new-contestants/scripts/generate.php <config.json>
```

Optional keys: `teamNo` (see below) and `columns` if the CSV column order differs from the default `{"name":0,"gender":1,"grade":2,"school":3,"province":4}`.

**Semifinalists.** `Contestant.TeamNo` records how a row counts: `1` = official (the default), `2` = the host country's guest team (IOI 2022), `3` = semifinalist. When the whole source list is a semifinal cohort — a file named `*semifinalis*`, or the user saying these are semifinalists — set `"teamNo": 3`.

When one CSV **mixes** cohorts, keep it in a single run: point `columns.teamNo` at the marker column and map every distinct value with `teamNoMap`.

```json
{
  "columns": {"name": 0, "school": 1, "province": 2, "teamNo": 3, "gender": 4, "grade": 5},
  "teamNoMap": {"": 1, "semifinalist": 3}
}
```

Markers are matched trimmed and lowercased, `""` being the blank cell; an unmapped value is a hard error. Do **not** split the CSV and generate each part separately — each run numbers new `Person` and `School` rows from that table's `MAX(ID) + 1`, so the two files would hand out the same IDs.

The script resolves people and schools against the DB, assigns explicit IDs continuing from each table's `MAX(ID)`, writes the three files, and then verifies them by applying both SQL files inside a transaction it always rolls back. It refuses to write anything when a school is unmapped, a province is unmatched, a gender is not `L`/`P`, or a person already has a row for this competition.

Use `MAX(ID) + 1` for new IDs, never `information_schema.TABLES.AUTO_INCREMENT` — that value is cached and can lag behind reality on this DB.

## Step 4 — report

Read the script's warnings and pass the substance to the user:

- **Near-duplicate people.** The script warns when a new name overlaps an existing `Person` by ≥60% of its tokens. Returning contestants are common and *must* reuse their existing `Person.ID`, so check each warning against `Contestant` history before accepting a new row: `... query.php "SELECT c.Competition, s.Name FROM Contestant c JOIN School s ON s.ID = c.School WHERE c.Person = <id>"`. A changed school is normal — `Contestant` stores the school per competition.
- **School mappings you were unsure about**, with the reasoning, so the user can correct them.
- Anything odd about the cohort — e.g. contestants who look like they should already be in the competition but aren't.

Then hand over the file paths and the run order (`_person_school.sql` first — the `Contestant` FKs depend on it). Say plainly that the DB is unchanged.

## Never

- Run `INSERT`/`UPDATE`/`ALTER` against the database, even to test. The transaction dry run in `generate.php` is the only write path, and it always rolls back. Note that DDL (`ALTER`, `CREATE`) implicitly commits in MySQL and would defeat that — so verify anything schema-related on a scratch copy of the database instead.
- Modify the source CSV.
