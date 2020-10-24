<?php namespace App\Controllers;

class Competition extends BaseController {
	public function index() {
		$q = $this->db->table('Competition c');
		$q->join('Province p', 'p.ID = c.Host');
		$q->select('c.ID as ID, c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Contestants, Provinces');
		$q->orderBy('DateBegin', 'DESC');
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
		$competition = $this->getCompetition($id);

		return view('competition_info', [
			'menu' => 'competition',
			'submenu' => 'info',
			'contentUrl' => '/' . $id,
			'competitionName' => $competition['Name'],
			'competitionHostName' => $competition['HostName'],
			'competitionCity' => $competition['City'],
			'competitionDateBegin' => $competition['DateBegin'],
			'competitionDateEnd' => $competition['DateEnd'],
			'competitionWebsite' => $competition['Website'],
			'competitionContestants' => $competition['Contestants'],
			'competitionProvinces' => $competition['Provinces'],
		]);
	}

	public function result($id) {
		helper('score');
		helper('medal');

		$competition = $this->getCompetition($id);

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
			array_push($row, formatScore($c['Score'], $competition['ScorePr']), getMedalName($c['Medal']));

			$clazz = getMedalClass($c['Medal']);
			$table->addRow(array_map(function($v) use ($clazz) { return ['data' => $v, 'class' => $clazz]; }, $row));
		}

		return view('competition_result', [
			'menu' => 'competition',
			'submenu' => 'result',
			'contentUrl' => '/' . $id,
			'competitionName' => $competition['Name'],
			'table' => $table->generate()
		]);
	}

	private function getCompetition($id) {
		$q = $this->db->table('Competition c');
		$q->join('Province p', 'p.ID = c.Host');
		$q->select('c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Website, Contestants, Provinces, ScorePr');
		$q->where('c.ID', $id);
		$competitions = $q->get()->getResultArray();

		if (empty($competitions)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		return $competitions[0];
	}
}
