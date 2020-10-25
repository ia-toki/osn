<?php namespace App\Controllers;

class Competition extends BaseController {
	public function index() {
		$q = $this->db->table('Competition c');
		$q->join('Province p', 'p.ID = c.Host');
		$q->select('c.ID as ID, c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Contestants, Provinces');
		$q->orderBy('Year', 'DESC');
		$competitions = $q->get()->getResultArray();

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
				date_format(date_create($c['DateBegin']), 'd M Y') . ' &ndash; ' . date_format(date_create($c['DateEnd']), 'd M Y'),
				$c['Contestants'],
				$c['Provinces']
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

		$q = $this->db->table('Contestant c');
		$q->join('Person p', 'p.ID = c.Person');
		$q->join('Province pr', 'pr.ID = c.Province');
		$q->where('Competition', $id);
		$q->select('c.ID as ID, Rank, p.Name as Name, pr.Name as Province, Score, Medal');
		$q->orderBy('Rank', 'ASC');
		$contestants = $q->get()->getResultArray();

		$q = $this->db->table('Task');
		$q->where('Competition', $id);
		$q->select('Alias, ScorePr');
		$q->orderBy('Alias', 'ASC');
		$tasks = $q->get()->getResultArray();

		$q = $this->db->table('Submission s');
		$q->join('Contestant c', 'c.ID = s.Contestant');
		$q->join('Task t', 't.ID = s.Task');
		$q->where('c.Competition', $id);
		$q->select('c.ID as ContestantID, t.Alias as TaskAlias, s.Score as TaskScore, t.ScorePr as TaskScorePr');
		$submissions = $q->get()->getResultArray();

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

		$heading = array('#', 'Nama', 'Provinsi');
		foreach ($tasks as $t) {
			$heading[] = $t['Alias'];
		}
		array_push($heading, 'Total', 'Medali');
		$table->setHeading($heading);

		foreach ($contestants as $c) {
			$row = array($c['Rank'], $c['Name'], $c['Province']);
			foreach ($tasks as $t) {
				$row[] = $taskScores[$c['ID']][$t['Alias']];
			}
			array_push($row, formatScore($c['Score'], $data['competition']['ScorePr']), getMedalName($c['Medal']));

			$clazz = getMedalClass($c['Medal']);
			$table->addRow(array_map(function($v) use ($clazz) { return ['data' => $v, 'class' => $clazz]; }, $row));
		}

		return view('competition_results', array_merge($data, [
			'submenu' => '/hasil',
			'table' => $table->generate()
		]));
	}
	public function provinces($id) {
		helper('medal');

		$data = $this->getCompetition($id);

		$q = $this->db->query(<<<QUERY
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
		QUERY, [$id, $id, $id, $id]);

		$provinces = $q->getResultArray();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-bordered">'
		]);

		$table->setHeading('Provinsi', 'Emas', 'Perak', 'Perunggu', 'Total');

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
		$q = $this->db->table('Competition c');
		$q->join('Province p', 'p.ID = c.Host');
		$q->select('c.ID as ID, Year, c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Website, Contestants, Provinces, ScorePr');
		$q->where('c.ID', $id);
		$competitions = $q->get()->getResultArray();

		if (empty($competitions)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$competition = $competitions[0];

		$data = [
			'menu' => 'competition',
			'competition' => $competition
		];

		$q = $this->db->table('Competition');
		$q->select('ID, Year');
		$q->whereIn('Year', array($competition['Year']-1, $competition['Year']+1));
		$competitions = $q->get()->getResultArray();

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
