<?php namespace App\Controllers;

class Statistics extends BaseController {
	public function national() {
		helper('medal');

		$medals = $this->getNationalMedals();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

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
			'submenu' => '/nasional',
			'table' => $table->generate()
		]);
	}
	public function provinces() {
		helper('medal');
		helper('link');

		$medals = $this->getProvinceMedals(null, null);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

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
			select c.ID as ID, Competition, comp.ShortName as CompetitionName, p.ID as PersonID, c.Rank as 'Rank', p.Name as Name, Score, comp.ScorePr as ScorePr, Medal
			from Contestant c
			join Competition comp on comp.ID = c.Competition
			join Person p on p.ID = c.Person
			where c.Province = ?
			order by comp.Year desc, c.Rank asc
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
			if (empty($taskScores[$s['CompetitionID']])) {
				$taskScores[$s['CompetitionID']] = array();
			}
			if (empty($taskScores[$s['CompetitionID']][$s['ContestantID']])) {
				$taskScores[$s['CompetitionID']][$s['ContestantID']] = array();
			}
			$taskScores[$s['CompetitionID']][$s['ContestantID']][] = formatScore($s['TaskScore'], $s['TaskScorePr']);
			$taskCount = max($taskCount, count($taskScores[$s['CompetitionID']][$s['ContestantID']]));
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

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			'Kompetisi',
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
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
			$row[] = ['data' => $c['Rank'], 'class' => 'col-rank ' . $clazz];
			$row[] = ['data' => linkPerson($c['PersonID'], $c['Name']), 'class' => $clazz];

			$tasks = 0;
			if (isset($taskScores[$c['Competition']])) {
				foreach ($taskScores[$c['Competition']][$c['ID']] as $t) {
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
			'submenu' => '',
			'province' => $province,
			'medalsTable' => $medalsTable->generate(),
			'table' => $table->generate()
		]);
	}

	public function persons() {
		helper('score');
		helper('medal');
		helper('link');

		$medals = $this->getPersonMedals(null);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			'Angkatan',
			createMedalHeading('Internasional'),
			createMedalHeading('Regional'),
			createMedalHeading('Nasional')
		);
		$table->setHeading($heading);

		foreach ($medals as $m) {
			$table->addRow(
				['data' => $m['Rank'], 'class' => 'col-rank'],
				linkPerson($m['ID'], $m['Name']),
				['data' => max($m['InternationalBatch'], 1 + $m['NationalBatch']), 'class' => 'col-batch'],
				...createMedalCells($m, 'International', null),
				...createMedalCells($m, 'Regional', null),
				...createMedalCells($m, 'National', null)
			);
		}

		return view('statistics_persons', [
			'menu' => 'statistics',
			'submenu' => '/',
			'table' => $table->generate()
		]);
	}

	public function person($id) {
		helper('score');
		helper('medal');
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
			select c.ID as ID, Competition, comp.Level as CompetitionLevel, comp.ShortName as CompetitionName, pr.ID as ProvinceID, pr.Name as ProvinceName, c.Rank as 'Rank', Score, comp.ScorePr as ScorePr, Medal
			from Contestant c
			join Competition comp on comp.ID = c.Competition
			left join Province pr on pr.ID = c.Province
			where c.Person = ?
			order by comp.Year desc, c.Rank asc
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

		$medals = $this->getPersonMedals($id);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

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
			'internationalTable' => $this->getExternalStatistics('International', $contestants, $submissions),
			'regionalTable' => $this->getExternalStatistics('Regional', $contestants, $submissions),
			'nationalTable' => $this->getNationalStatistics($contestants, $submissions)
		]);
	}

	private function getExternalStatistics($level, $contestants, $submissions) {
		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			'Kompetisi',
			['data' => '#', 'class' => 'col-centered'],
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
				['data' => $c['Rank'], 'class' => 'col-rank ' . $clazz]
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

	private function getNationalStatistics($contestants, $submissions) {
		$taskCount = 1;
		$taskScores = array();
		foreach ($submissions as $s) {
			if (empty($taskScores[$s['CompetitionID']])) {
				$taskScores[$s['CompetitionID']] = array();
			}
			$taskScores[$s['CompetitionID']][] = formatScore($s['TaskScore'], $s['TaskScorePr']);
			$taskCount = max($taskCount, count($taskScores[$s['CompetitionID']]));
		}

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			'Kompetisi',
			'Provinsi',
			['data' => '#', 'class' => 'col-centered'],
			['data' => 'Nilai', 'colspan' => $taskCount, 'class' => 'col-centered'],
			['data' => 'Total', 'class' => 'col-centered'],
			'Medali'
		);
		$table->setHeading($heading);

		$rowCount = 0;
		foreach ($contestants as $c) {
			if ($c['CompetitionLevel'] != 'National') {
				continue;
			}

			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => linkCompetition($c['Competition'], $c['CompetitionName']), 'class' => $clazz],
				['data' => linkProvince($c['ProvinceID'], $c['ProvinceName']), 'class' => $clazz],
				['data' => $c['Rank'], 'class' => 'col-rank ' . $clazz]
			);

			$tasks = 0;
			if (isset($taskScores[$c['Competition']])) {
				foreach ($taskScores[$c['Competition']] as $t) {
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
}
