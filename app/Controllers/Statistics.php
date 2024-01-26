<?php namespace App\Controllers;

class Statistics extends BaseController {
	public function national() {
		helper('medal');

		$medals = $this->getNationalMedals();

		$table = createTable();
		$heading = array(
			createMedalHeading('Internasional'),
			createMedalHeading('Regional')
		);
		$table->setHeading($heading);

		$table->addRow(
			...createMedalCells($medals[0], '', 'col-statistics-person-medal'),
			...createMedalCells($medals[1], '', 'col-statistics-person-medal'),
		);

		return view('statistics_national', [
			'menu' => 'statistics',
			'submenu' => '/indonesia',
			'table' => $table->generate()
		]);
	}

	public function provinces() {
		helper('medal');
		helper('link');

		$medals = $this->getProvinceMedals(null, null);

		$table = createTable();
		$table->setHeading(
			['data' => '#', 'class' => 'col-centered'],
			'Provinsi',
			createMedalHeading('Nasional')
		);

		foreach ($medals as $m) {
			$table->addRow(
				['data' => $m['Rank'], 'class' => 'col-rank'],
				linkProvince($m['ID'], $m['Name']),
				...createMedalCells($m, '', null)
			);
		}

		return view('statistics_provinces', [
			'menu' => 'statistics',
			'submenu' => '/provinsi',
			'table' => $table->generate()
		]);
	}
	
	public function province($id) {
		helper('score');
		helper('medal');
		helper('link');

		$provinces = $this->db->query(<<<QUERY
			select ID, Name from Province
			where ID = ?
		QUERY, [$id])->getResultArray();

		if (empty($provinces)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$province = $provinces[0];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, TeamNo, Competition, comp.ShortName as CompetitionName, p.ID as PersonID, c.Rank as 'Rank', p.Name as Name, s.ID as SchoolID, s.Name as SchoolName, Score, comp.ScorePr as ScorePr, Medal
			from Contestant c
			join Competition comp on comp.ID = c.Competition
			join Person p on p.ID = c.Person
			left join School s on s.ID = c.School
			where c.Province = ?
			order by comp.Year desc, -c.Rank desc
		QUERY, [$id])->getResultArray();

		$contestantCounts = $this->db->query(<<<QUERY
			select Competition, count(ID) as Count
			from Contestant
			where Province = ?
			group by Competition
		QUERY, [$id])->getResultArray();

		$submissions = $this->db->query(<<<QUERY
			select comp.ID as CompetitionID, c.ID as ContestantID, s.Score as TaskScore, t.ScorePr as TaskScorePr
			from Submission s
			join Contestant c on c.ID = s.Contestant
			join Competition comp on comp.ID = c.Competition
			join Task t on t.ID = s.Task
			where c.Province = ?
			order by t.Alias asc
		QUERY, [$id])->getResultArray();

		$contestantCountsMap = array();
		foreach ($contestantCounts as $c) {
			$contestantCountsMap[$c['Competition']] = $c['Count'];
		}

		$taskCount = 1;
		$taskScores = array();
		foreach ($submissions as $s) {
			if (empty($taskScores[$s['ContestantID']])) {
				$taskScores[$s['ContestantID']] = array();
			}
			$taskScores[$s['ContestantID']][] = formatScore($s['TaskScore'], $s['TaskScorePr']);
			$taskCount = max($taskCount, count($taskScores[$s['ContestantID']]));
		}

		$medals = $this->getProvinceMedals($id, null);

		$medalsTable = new \CodeIgniter\View\Table();
		$medalsTable->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			createMedalHeading('Nasional')
		);
		$medalsTable->setHeading($heading);

		$medalsTable->addRow(
			...createMedalCells($medals[0], '', 'col-statistics-person-medal')
		);

		$table = createTable();
		$heading = array(
			['data' => 'Olimpiade', 'class' => 'col-competition-short'],
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			'Sekolah',
			['data' => 'Nilai', 'colspan' => $taskCount, 'class' => 'col-centered'],
			['data' => 'Total', 'class' => 'col-centered'],
			'Medali'
		);
		$table->setHeading($heading);

		$curCompetition = '';
		foreach ($contestants as $c) {
			$clazz = '';

			$row = array();
			if ($c['Competition'] != $curCompetition) {
				$clazz = $clazz . ' col-new-competition';
				$row[] = [
					'data' => linkCompetition($c['Competition'], $c['CompetitionName']),
					'class' => $clazz,
					'rowspan' => $contestantCountsMap[$c['Competition']]
				];
			}
			$curCompetition = $c['Competition'];
			$clazz = $clazz . ' ' . getMedalClass($c['Medal']);
			$row[] = ['data' => $c['TeamNo'] == 1 ? $c['Rank'] : '', 'class' => 'col-rank ' . $clazz];
			$row[] = ['data' => linkPerson($c['PersonID'], $c['Name']), 'class' => $clazz];
			$row[] = ['data' => linkSchool($c['SchoolID'], $c['SchoolName']), 'class' => $clazz];

			$tasks = 0;
			if (isset($taskScores[$c['ID']])) {
				foreach ($taskScores[$c['ID']] as $t) {
					$row[] = ['data' => $t, 'class' => 'col-score ' . $clazz];
					$tasks++;
				}
			}

			if ($tasks < $taskCount) {
				$row[] = ['class' => 'col-score ' . $clazz, 'colspan' => $taskCount-$tasks];
			}

			$row[] = ['data' => formatScore($c['Score'], $c['ScorePr']), 'class' => 'col-score ' . $clazz];
			$row[] = ['data' => getMedalName($c['Medal']), 'class' => 'col-medal ' . $clazz];

			$table->addRow($row);
		}

		return view('statistics_province', [
			'menu' => 'statistics',
			'submenu' => '/provinsi',
			'province' => $province,
			'medalsTable' => $medalsTable->generate(),
			'table' => $table->generate()
		]);
	}

	public function schools() {
		helper('score');
		helper('medal');
		helper('link');

		$nameFilter = trim((string) $this->request->getVar('name'));
		if (strlen($nameFilter) < 3) {
			$nameFilter = null;
		}
		$medals = $this->getSchoolMedals(null, $nameFilter);

		$table = createTable();
		$heading = array(
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			createMedalHeading('Internasional'),
			createMedalHeading('Regional'),
			createMedalHeading('Nasional')
		);
		$table->setHeading($heading);

		foreach ($medals as $m) {
			$table->addRow(
				['data' => $m['Rank'], 'class' => 'col-rank'],
				linkSchool($m['ID'], $m['Name']),
				...createMedalCells($m, 'International', null),
				...createMedalCells($m, 'Regional', null),
				...createMedalCells($m, 'National', null)
			);
		}

		return view('statistics_persons', [
			'menu' => 'statistics',
			'submenu' => '/sekolah',
			'table' => $table->generate(),
			'nameFilter' => $nameFilter
		]);
	}

	public function school($id) {
		helper('score');
		helper('medal');
		helper('link');

		$schools = $this->db->query(<<<QUERY
			select ID, Name from School
			where ID = ?
		QUERY, [$id])->getResultArray();

		if (empty($schools)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$school = $schools[0];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, TeamNo, Competition, comp.Level as CompetitionLevel, comp.ShortName as CompetitionName, p.ID as PersonID, p.Name as PersonName, s.ID as SchoolID, s.Name as SchoolName, pr.ID as ProvinceID, pr.Name as ProvinceName, c.Rank as 'Rank', Score, comp.ScorePr as ScorePr, Medal
			from Contestant c
			join Competition comp on comp.ID = c.Competition
			left join Person p on p.ID = c.Person
			left join Province pr on pr.ID = c.Province
			left join School s on s.ID=c.School
			where c.School = ?
			order by comp.Year desc, -c.Rank desc
		QUERY, [$id])->getResultArray();

		$submissions = $this->db->query(<<<QUERY
			select comp.ID as CompetitionID, c.ID as ContestantID, s.Score as TaskScore, t.ScorePr as TaskScorePr
			from Submission s
			join Contestant c on c.ID = s.Contestant
			join Competition comp on comp.ID = c.Competition
			join Task t on t.ID = s.Task
			where c.School = ?
			order by t.Alias asc
		QUERY, [$id])->getResultArray();

		$medals = $this->getSchoolMedals($id, null);

		$table = createTable();
		$heading = array(
			createMedalHeading('Internasional'),
			createMedalHeading('Regional'),
			createMedalHeading('Nasional')
		);
		$table->setHeading($heading);

		$table->addRow(
			...createMedalCells($medals[0], 'International', 'col-statistics-person-medal'),
			...createMedalCells($medals[0], 'Regional', 'col-statistics-person-medal'),
			...createMedalCells($medals[0], 'National', 'col-statistics-person-medal')
		);

		return view('statistics_person', [
			'menu' => 'statistics',
			'submenu' => '/sekolah',
			'person' => $school,
			'medalsTable' => $table->generate(),
			'internationalTable' => $this->getExternalStatistics(false, 'International', $contestants, $submissions),
			'regionalTable' => $this->getExternalStatistics(false, 'Regional', $contestants, $submissions),
			'nationalTable' => $this->getNationalStatistics(false, $contestants, $submissions)
		]);
	}

	public function persons() {
		helper('score');
		helper('medal');
		helper('link');

		$nameFilter = trim((string) $this->request->getVar('name'));
		if (strlen($nameFilter) < 3) {
			$nameFilter = null;
		}
		$medals = $this->getPersonMedals(null, $nameFilter);

		$table = createTable();
		$heading = array(
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			createMedalHeading('Internasional'),
			createMedalHeading('Regional'),
			createMedalHeading('Nasional')
		);
		$table->setHeading($heading);

		foreach ($medals as $m) {
			$table->addRow(
				['data' => $m['Rank'], 'class' => 'col-rank'],
				linkPerson($m['ID'], $m['Name']),
				...createMedalCells($m, 'International', null),
				...createMedalCells($m, 'Regional', null),
				...createMedalCells($m, 'National', null)
			);
		}

		return view('statistics_persons', [
			'menu' => 'statistics',
			'submenu' => '/',
			'table' => $table->generate(),
			'nameFilter' => $nameFilter
		]);
	}

	public function person($id) {
		helper('score');
		helper('medal');
		helper('committee');
		helper('link');

		$persons = $this->db->query(<<<QUERY
			select ID, Name from Person
			where ID = ?
		QUERY, [$id])->getResultArray();

		if (empty($persons)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$person = $persons[0];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, TeamNo, Competition, comp.Level as CompetitionLevel, comp.ShortName as CompetitionName, s.ID as SchoolID, s.Name as SchoolName, pr.ID as ProvinceID, pr.Name as ProvinceName, c.Rank as 'Rank', Score, comp.ScorePr as ScorePr, Medal
			from Contestant c
			join Competition comp on comp.ID = c.Competition
			left join School s on s.ID = c.School
			left join Province pr on pr.ID = c.Province
			where c.Person = ?
			order by comp.Year desc, -c.Rank desc
		QUERY, [$id])->getResultArray();

		$submissions = $this->db->query(<<<QUERY
			select comp.ID as CompetitionID, c.ID as ContestantID, s.Score as TaskScore, t.ScorePr as TaskScorePr
			from Submission s
			join Contestant c on c.ID = s.Contestant
			join Competition comp on comp.ID = c.Competition
			join Task t on t.ID = s.Task
			where c.Person = ?
			order by t.Alias asc
		QUERY, [$id])->getResultArray();

		$committee = $this->db->query(<<<QUERY
			select c.Competition, comp.ShortName as CompetitionName, c.Role, c.Chair
			from Committee c
			join Competition comp on comp.ID = c.Competition
			where c.Person = ?
			order by comp.Year desc
		QUERY, [$id])->getResultArray();

		$medals = $this->getPersonMedals($id, null);

		$table = createTable();
		$heading = array(
			createMedalHeading('Internasional'),
			createMedalHeading('Regional'),
			createMedalHeading('Nasional')
		);
		$table->setHeading($heading);

		$table->addRow(
			...createMedalCells($medals[0], 'International', 'col-statistics-person-medal'),
			...createMedalCells($medals[0], 'Regional', 'col-statistics-person-medal'),
			...createMedalCells($medals[0], 'National', 'col-statistics-person-medal')
		);

		return view('statistics_person', [
			'menu' => 'statistics',
			'submenu' => '/',
			'person' => $person,
			'medalsTable' => $table->generate(),
			'internationalTable' => $this->getExternalStatistics(true, 'International', $contestants),
			'regionalTable' => $this->getExternalStatistics(true, 'Regional', $contestants),
			'nationalTable' => $this->getNationalStatistics(true, $contestants, $submissions),
			'committeeTable' => $this->getCommitteeStatistics($committee),
		]);
	}

	private function getExternalStatistics($isPerson, $level, $contestants) {
		$table = createTable();
		$heading = array(
			['data' => 'Olimpiade', 'class' => 'col-competition-short'],
			['data' => '#', 'class' => 'col-centered'],
			$isPerson ? 'Sekolah' : 'Nama',
			'Medali'
		);
		$table->setHeading($heading);

		$rowCount = 0;
		foreach ($contestants as $c) {
			if ($c['CompetitionLevel'] != $level) {
				continue;
			}

			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => linkCompetition($c['Competition'], $c['CompetitionName']), 'class' => $clazz],
				['data' => $c['TeamNo'] == 1 ? $c['Rank'] : '', 'class' => 'col-rank ' . $clazz],
				['data' => $isPerson ? linkSchool($c['SchoolID'], $c['SchoolName']) : linkPerson($c['PersonID'], $c['PersonName']), 'class' => $clazz]
			);

			$row[] = ['data' => getMedalName($c['Medal']), 'class' => 'col-medal ' . $clazz];

			$table->addRow($row);
			$rowCount++;
		}

		if ($rowCount > 0) {
			return $table->generate();
		}
		return null;
	}

	private function getNationalStatistics($isPerson, $contestants, $submissions) {
		$taskCount = 1;
		$taskScores = array();
		foreach ($submissions as $s) {
			if (empty($taskScores[$s['ContestantID']])) {
				$taskScores[$s['ContestantID']] = array();
			}
			$taskScores[$s['ContestantID']][] = formatScore($s['TaskScore'], $s['TaskScorePr']);
			$taskCount = max($taskCount, count($taskScores[$s['ContestantID']]));
		}

		$table = createTable();
		$heading = array(
			['data' => 'Olimpiade', 'class' => 'col-competition-short'],
			['data' => '#', 'class' => 'col-centered'],
			$isPerson ? 'Sekolah' : 'Nama'
		);
		if ($isPerson) {
			$heading[] = ['data' => 'Provinsi', 'class' => 'col-province'];
		}
		$heading = array_merge($heading, array(
			['data' => 'Nilai', 'colspan' => $taskCount, 'class' => 'col-centered'],
			['data' => 'Total', 'class' => 'col-centered'],
			'Medali'
		));
		$table->setHeading($heading);

		$rowCount = 0;
		foreach ($contestants as $c) {
			if ($c['CompetitionLevel'] != 'National') {
				continue;
			}

			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => linkCompetition($c['Competition'], $c['CompetitionName']), 'class' => $clazz],
				['data' => $c['TeamNo'] == 1 ? $c['Rank'] : '', 'class' => 'col-rank ' . $clazz],
				['data' => $isPerson ? linkSchool($c['SchoolID'], $c['SchoolName']) : linkPerson($c['PersonID'], $c['PersonName']), 'class' => $clazz]
			);
			if ($isPerson) {
				$row [] = ['data' => linkProvince($c['ProvinceID'], $c['ProvinceName']), 'class' => $clazz];
			}

			$tasks = 0;
			if (isset($taskScores[$c['ID']])) {
				foreach ($taskScores[$c['ID']] as $t) {
					$row[] = ['data' => $t, 'class' => 'col-score ' . $clazz];
					$tasks++;
				}
			}

			if ($tasks < $taskCount) {
				$row[] = ['class' => 'col-score ' . $clazz, 'colspan' => $taskCount-$tasks];
			}

			$row[] = ['data' => formatScore($c['Score'], $c['ScorePr']), 'class' => 'col-score ' . $clazz];
			$row[] = ['data' => getMedalName($c['Medal']), 'class' => 'col-medal ' . $clazz];

			$table->addRow($row);
			$rowCount++;
		}

		if ($rowCount > 0) {
			return $table->generate();
		}
		return null;
	}

	private function getCommitteeStatistics($committee) {
		$table = createTable();
		$heading = array(
			['data' => 'Olimpiade', 'class' => 'col-competition-short'],
			'Jabatan'
		);
		$table->setHeading($heading);

		$rowCount = 0;
		foreach ($committee as $c) {
			$row = array(
				linkCompetitionInfo($c['Competition'], $c['CompetitionName']),
				getCommitteeTitle($c['Role']),
			);
			$table->addRow($row);
			$rowCount++;
		}

		if ($rowCount > 0) {
			return $table->generate();
		}
		return null;
	}
}
