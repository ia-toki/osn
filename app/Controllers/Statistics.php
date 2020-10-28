<?php namespace App\Controllers;

class Statistics extends BaseController {
	public function provinces() {
		helper('medal');
		helper('link');

		$medals = $this->getProvinceMedals();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$table->setHeading(
			'Provinsi',
			['data' => 'Nasional', 'class' => 'col-centered', 'colspan' => 4]
		);

		foreach ($medals as $m) {
			$table->addRow(
				linkProvince($m['ID'], $m['Name']),
				['data' => $m['Golds'], 'class' => 'col-medals ' . getMedalClass('G')],
				['data' => $m['Silvers'], 'class' => 'col-medals ' . getMedalClass('S')],
				['data' => $m['Bronzes'], 'class' => 'col-medals ' . getMedalClass('B')],
				['data' => $m['Participants'], 'class' => 'col-medals'],
			);
		}

		return view('statistics_provinces', [
			'menu' => 'statistics',
			'submenu' => '',
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
			'Nama',
			['data' => 'Internasional', 'class' => 'col-centered', 'colspan' => '4'],
			['data' => 'Regional', 'class' => 'col-centered', 'colspan' => '4'],
			['data' => 'Nasional', 'class' => 'col-centered', 'colspan' => '4']
		);
		$table->setHeading($heading);

		foreach ($medals as $m) {
			$table->addRow(
				linkPerson($m['ID'], $m['Name']),
				['data' => $m['InternationalGolds'] ?? '-', 'class' => 'col-medals medal--gold'],
				['data' => $m['InternationalSilvers'] ?? '-', 'class' => 'col-medals medal--silver'],
				['data' => $m['InternationalBronzes'] ?? '-', 'class' => 'col-medals medal--bronze'],
				['data' => $m['InternationalParticipants'] ?? '-', 'class' => 'col-medals'],
				['data' => $m['RegionalGolds'] ?? '-', 'class' => 'col-medals medal--gold'],
				['data' => $m['RegionalSilvers'] ?? '-', 'class' => 'col-medals medal--silver'],
				['data' => $m['RegionalBronzes'] ?? '-', 'class' => 'col-medals medal--bronze'],
				['data' => $m['RegionalParticipants'] ?? '-', 'class' => 'col-medals'],
				['data' => $m['NationalGolds'] ?? '-', 'class' => 'col-medals medal--gold'],
				['data' => $m['NationalSilvers'] ?? '-', 'class' => 'col-medals medal--silver'],
				['data' => $m['NationalBronzes'] ?? '-', 'class' => 'col-medals medal--bronze'],
				['data' => $m['NationalParticipants'] ?? '-', 'class' => 'col-medals'],
			);
		}

		return view('statistics_persons', [
			'menu' => 'statistics',
			'submenu' => '/peserta',
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
			['data' => 'Internasional', 'class' => 'col-centered', 'colspan' => '4'],
			['data' => 'Regional', 'class' => 'col-centered', 'colspan' => '4'],
			['data' => 'Nasional', 'class' => 'col-centered', 'colspan' => '4']
		);
		$table->setHeading($heading);

		$table->addRow(
			['data' => $medals[0]['InternationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['InternationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['InternationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
			['data' => $medals[0]['InternationalParticipants'] ?? '-', 'class' => 'col-statistics-person-medal'],
			['data' => $medals[0]['RegionalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['RegionalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['RegionalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
			['data' => $medals[0]['RegionalParticipants'] ?? '-', 'class' => 'col-statistics-person-medal'],
			['data' => $medals[0]['NationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['NationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['NationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
			['data' => $medals[0]['NationalParticipants'] ?? '-', 'class' => 'col-statistics-person-medal']
		);

		return view('statistics_person', [
			'menu' => 'statistics',
			'submenu' => '/peserta',
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
