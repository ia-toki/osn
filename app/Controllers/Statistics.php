<?php namespace App\Controllers;

class Statistics extends BaseController {
	public function provinces() {
		helper('medal');
		helper('link');

		$provinces = $this->db->query(<<<QUERY
			select p.ID as ID, pr.Name as Name, coalesce(Golds, 0) as Golds, coalesce(Silvers, 0) as Silvers, coalesce(Bronzes, 0) as Bronzes, coalesce(Golds, 0) + coalesce(Silvers, 0) + coalesce(Bronzes, 0) as Medals from (
				select distinct(Province) as ID from Contestant
			) as p
			join Province pr on p.ID = pr.ID
			left join (
				select Province as ID, count(Medal) as Golds
				from Contestant
				where Medal = 'G'
				group by Province
			) as golds on p.ID = golds.ID
			left join (
				select Province as ID, count(Medal) as Silvers
				from Contestant
				where Medal = 'S'
				group by Province
			) as silvers on p.ID = silvers.ID
			left join (
				select Province as ID, count(Medal) as Bronzes
				from Contestant
				where Medal = 'B'
				group by Province
			) as bronzes on p.ID = bronzes.ID
			order by Golds desc, Silvers desc, Bronzes desc, Name asc
		QUERY)->getResultArray();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$table->setHeading(
			'Provinsi',
			['data' => 'Emas', 'class' => 'col-centered'],
			['data' => 'Perak', 'class' => 'col-centered'],
			['data' => 'Perunggu', 'class' => 'col-centered'],
			['data' => 'Total', 'class' => 'col-centered']
		);

		foreach ($provinces as $p) {
			$table->addRow(
				linkProvince($p['ID'], $p['Name']),
				['data' => $p['Golds'], 'class' => 'col-medals ' . getMedalClass('G')],
				['data' => $p['Silvers'], 'class' => 'col-medals ' . getMedalClass('S')],
				['data' => $p['Bronzes'], 'class' => 'col-medals ' . getMedalClass('B')],
				['data' => $p['Medals'], 'class' => 'col-medals'],
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

		$medals = $this->getMedalStatistics(null);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			'Nama',
			['data' => 'Internasional', 'class' => 'col-centered', 'colspan' => '3'],
			['data' => 'Regional', 'class' => 'col-centered', 'colspan' => '3'],
			['data' => 'Nasional', 'class' => 'col-centered', 'colspan' => '3']
		);
		$table->setHeading($heading);

		foreach ($medals as $m) {
			$table->addRow(
				linkPerson($m['ID'], $m['Name']),
				['data' => $m['InternationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
				['data' => $m['InternationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
				['data' => $m['InternationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
				['data' => $m['RegionalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
				['data' => $m['RegionalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
				['data' => $m['RegionalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
				['data' => $m['NationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
				['data' => $m['NationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
				['data' => $m['NationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
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

		$medals = $this->getMedalStatistics($id);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			['data' => 'Internasional', 'class' => 'col-centered', 'colspan' => '3'],
			['data' => 'Regional', 'class' => 'col-centered', 'colspan' => '3'],
			['data' => 'Nasional', 'class' => 'col-centered', 'colspan' => '3']
		);
		$table->setHeading($heading);

		$table->addRow(
			['data' => $medals[0]['InternationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['InternationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['InternationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
			['data' => $medals[0]['RegionalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['RegionalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['RegionalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
			['data' => $medals[0]['NationalGolds'] ?? '-', 'class' => 'col-statistics-person-medal medal--gold'],
			['data' => $medals[0]['NationalSilvers'] ?? '-', 'class' => 'col-statistics-person-medal medal--silver'],
			['data' => $medals[0]['NationalBronzes'] ?? '-', 'class' => 'col-statistics-person-medal medal--bronze'],
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

	private function getMedalStatistics($id) {
		return $this->db->query(sprintf(<<<QUERY
			select c.ID as ID, Name, InternationalGolds, InternationalSilvers, InternationalBronzes, RegionalGolds, RegionalSilvers, RegionalBronzes, NationalGolds, NationalSilvers, NationalBronzes from (
				select ID, Name from Person %s
			) as c
			left join (
				select Person, count(Medal) as InternationalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'G'
				group by Person
			) as iGolds on c.ID = iGolds.Person
			left join (
				select Person, count(Medal) as InternationalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'S'
				group by Person
			) as iSilvers on c.ID = iSilvers.Person
			left join (
				select Person, count(Medal) as InternationalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'B'
				group by Person
			) as iBronzes on c.ID = iBronzes.Person
			left join (
				select Person, count(Medal) as RegionalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'G'
				group by Person
			) as rGolds on c.ID = rGolds.Person
			left join (
				select Person, count(Medal) as RegionalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'S'
				group by Person
			) as rSilvers on c.ID = rSilvers.Person
			left join (
				select Person, count(Medal) as RegionalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'B'
				group by Person
			) as rBronzes on c.ID = rBronzes.Person
			left join (
				select Person, count(Medal) as NationalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'G'
				group by Person
			) as nGolds on c.ID = nGolds.Person
			left join (
				select Person, count(Medal) as NationalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'S'
				group by Person
			) as nSilvers on c.ID = nSilvers.Person
			left join (
				select Person, count(Medal) as NationalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'B'
				group by Person
			) as nBronzes on c.ID = nBronzes.Person
			order by InternationalGolds desc, InternationalSilvers desc, InternationalBronzes desc, RegionalGolds desc, RegionalSilvers desc, RegionalBronzes desc, NationalGolds desc, NationalSilvers desc, NationalBronzes desc, Name asc
			limit 100
		QUERY, $id ? 'where ID = ?' : ''), [$id])->getResultArray();
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
