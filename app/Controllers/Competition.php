<?php namespace App\Controllers;

class Competition extends BaseController {
	public function index() {
		$competitions = $this->db->query(<<<QUERY
			select c.ID as ID, c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Contestants, Provinces from Competition c
			join Province p on p.ID = c.Host
			left join (
				select Competition, count(Person) as Contestants, count(distinct(Province)) as Provinces from Contestant
				group by Competition
			) as contestants on c.ID = contestants.Competition
			order by Year desc
		QUERY)->getResultArray();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-striped table-bordered">'
		]);

		$table->setHeading('#', 'Nama', 'Tuan Rumah', 'Kota', 'Waktu', 'Peserta', 'Provinsi');

		$competitionsCount = count($competitions);
		for ($i = 0; $i < $competitionsCount; $i++) {
			$c = $competitions[$i];
			$table->addRow(
				$competitionsCount-$i,
				'<a href="/' . $c['ID'] . '">' . $c['Name'] . '</a>',
				$c['HostName'],
				$c['City'],
				['data' => date_format(date_create($c['DateBegin']), 'd M Y') . ' &ndash; ' . date_format(date_create($c['DateEnd']), 'd M Y'), 'class' => 'col-centered'],
				['data' => $c['Contestants'], 'class' => 'col-centered'],
				['data' => $c['Provinces'], 'class' => 'col-centered']
			);
		}

		return view('competitions', [
			'menu' =>'competition',
			'table' => $table->generate()
		]);
	}

	public function info($id) {
		$data = $this->getCompetition($id);

		return view('competition_info', array_merge($data, [
			'submenu' => '',
		]));
	}

	public function results($id) {
		helper('score');
		helper('medal');

		$data = $this->getCompetition($id);

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, c.Rank as 'Rank', p.ID as PersonID, p.Name as Name, pr.Name as Province, Score, Medal
			from Contestant c
			join Person p on p.ID = c.Person
			join Province pr on pr.ID = c.Province
			where Competition = ?
			order by c.Rank asc
		QUERY, [$id])->getResultArray();

		$tasks = $this->db->query(<<<QUERY
			select Alias, ScorePr from Task
			where Competition = ?
			order by Alias asc
		QUERY, [$id])->getResultArray();

		$submissions = $this->db->query(<<<QUERY
			select c.ID as ContestantID, t.Alias as TaskAlias, s.Score as TaskScore, t.ScorePr as TaskScorePr
			from Submission s
			join Contestant c on c.ID = s.Contestant
			join Task t on t.ID = s.Task
			where c.Competition = ?
		QUERY, [$id])->getResultArray();

		$taskScores = array();
		foreach ($submissions as $s) {
			if (empty($taskScores[$s['ContestantID']])) {
				$taskScores[$s['ContestantID']] = array();
			}
			$taskScores[$s['ContestantID']][$s['TaskAlias']] = formatScore($s['TaskScore'], $s['TaskScorePr']);
		}

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$heading = array(
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			'Provinsi'
		);
		foreach ($tasks as $t) {
			$heading[] = ['data' => $t['Alias'], 'class' => 'col-centered'];
		}
		$heading[] = ['data' => 'Total', 'class' => 'col-centered'];
		$heading[] = 'Medali';
		$table->setHeading($heading);

		foreach ($contestants as $c) {
			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => $c['Rank'], 'class' => 'col-rank ' . $clazz],
				['data' => '<a href="/statistik/peserta/' . $c['PersonID'] . '">' . $c['Name'] . '</a>', 'class' => $clazz],
				['data' => $c['Province'], 'class' => 'col-province ' . $clazz]
			);
			foreach ($tasks as $t) {
				$row[] = ['data' => $taskScores[$c['ID']][$t['Alias']], 'class' => 'col-score ' . $clazz];
			}
			$row[] = ['data' => formatScore($c['Score'], $data['competition']['ScorePr']), 'class' => 'col-score ' . $clazz];
			$row[] = ['data' => getMedalName($c['Medal']), 'class' => 'col-medal ' . $clazz];

			$table->addRow($row);
		}

		return view('competition_results', array_merge($data, [
			'submenu' => '/hasil',
			'table' => $table->generate()
		]));
	}
	public function provinces($id) {
		helper('medal');

		$data = $this->getCompetition($id);

		$provinces = $this->db->query(<<<QUERY
			select p.ID as ID, pr.Name as Name, coalesce(Golds, 0) as Golds, coalesce(Silvers, 0) as Silvers, coalesce(Bronzes, 0) as Bronzes, coalesce(Golds, 0) + coalesce(Silvers, 0) + coalesce(Bronzes, 0) as Medals from (
				select distinct(Province) as ID from Contestant where Competition = ?
			) as p
			join Province pr on p.ID = pr.ID
			left join (
				select Province as ID, count(Medal) as Golds
				from Contestant
				where Competition = ?
				and Medal = 'G'
				group by Province
			) as golds on p.ID = golds.ID
			left join (
				select Province as ID, count(Medal) as Silvers
				from Contestant
				where Competition = ?
				and Medal = 'S'
				group by Province
			) as silvers on p.ID = silvers.ID
			left join (
				select Province as ID, count(Medal) as Bronzes
				from Contestant
				where Competition = ?
				and Medal = 'B'
				group by Province
			) as bronzes on p.ID = bronzes.ID
			order by Golds desc, Silvers desc, Bronzes desc, Name asc
		QUERY, [$id, $id, $id, $id])->getResultArray();

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
				$p['Name'],
				['data' => $p['Golds'], 'class' => 'col-medals ' . getMedalClass('G')],
				['data' => $p['Silvers'], 'class' => 'col-medals ' . getMedalClass('S')],
				['data' => $p['Bronzes'], 'class' => 'col-medals ' . getMedalClass('B')],
				['data' => $p['Medals'], 'class' => 'col-medals'],
			);
		}

		return view('competition_provinces', array_merge($data, [
			'submenu' => '/provinsi',
			'table' => $table->generate()
		]));
	}

	private function getCompetition($id) {
		$competitions = $this->db->query(<<<QUERY
			select c.ID as ID, Year, c.Name as Name, p.Name as HostName, Website, City, DateBegin, DateEnd, Contestants, Provinces, ScorePr from Competition c
			join Province p on p.ID = c.Host
			left join (
				select Competition, count(Person) as Contestants, count(distinct(Province)) as Provinces from Contestant
				group by Competition
			) as contestants on c.ID = contestants.Competition
			where c.ID = ?
		QUERY, [$id])->getResultArray();

		if (empty($competitions)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$competition = $competitions[0];

		$data = [
			'menu' => 'competition',
			'competition' => $competition
		];

		$competitions = $this->db->query(<<<QUERY
			select ID, Year from Competition
			where Year in (?, ?)
		QUERY, [$competition['Year']-1, $competition['Year']+1])->getResultArray();

		foreach ($competitions as $c) {
			if ($c['Year'] == $competition['Year']-1) {
				$data['prevCompetition'] = $c;
			}
			if ($c['Year'] == $competition['Year']+1) {
				$data['nextCompetition'] = $c;
			}
		}

		return $data;
	}
}
