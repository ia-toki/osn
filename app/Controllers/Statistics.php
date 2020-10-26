<?php namespace App\Controllers;

class Statistics extends BaseController {
	public function provinces() {
		helper('medal');

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
				'<a href="' . '/statistik/provinsi/' . $p['ID'] . '">' . $p['Name'] . '</a>',
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

		$provinces = $this->db->query(<<<QUERY
			select ID, Name from Province
			where ID = ?
		QUERY, [$id])->getResultArray();

		if (empty($provinces)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$province = $provinces[0];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, Competition, c.Rank as 'Rank', p.Name as Name, Score, comp.ScorePr as ScorePr, Medal
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

		$taskCount = 0;
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
				$row[] = ['data' => $c['Competition'], 'class' => $clazz, 'rowspan' => $contestantCountsMap[$c['Competition']]];
			}
			$curCompetition = $c['Competition'];
			$clazz = $clazz . ' ' . getMedalClass($c['Medal']);
			$row[] = ['data' => $c['Rank'], 'class' => 'col-rank ' . $clazz];
			$row[] = ['data' => $c['Name'], 'class' => $clazz];

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
}
