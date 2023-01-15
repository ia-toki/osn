<?php namespace App\Controllers;

class Competition extends BaseController {
	public function listNational() {
		helper('link');
		helper('date');

		$competitions = $this->getCompetitions(null, 'National');

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-striped table-bordered">'
		]);

		$table->setHeading(['data' => '#', 'class' => 'col-order'], 'Nama', 'Tuan Rumah', 'Kota', 'Waktu', 'Peserta', 'Provinsi');

		$competitionsCount = count($competitions);
		for ($i = 0; $i < $competitionsCount; $i++) {
			$c = $competitions[$i];
			$table->addRow(
				$competitionsCount-$i,
				linkCompetitionInfo($c['ID'], $c['Name']),
				$c['ProvinceID'] ? linkProvince($c['ProvinceID'], $c['HostName']) : '-',
				$c['City'],
				['data' => formatDateRange($c['DateBegin'], $c['DateEnd']), 'class' => 'col-centered'],
				['data' => $c['Contestants'], 'class' => 'col-centered'],
				['data' => $c['Provinces'], 'class' => 'col-centered']
			);
		}

		return view('competitions', [
			'menu' =>'competition',
			'submenu' => '/',
			'table' => $table->generate()
		]);
	}

	public function listInternational() {
		return $this->listExternal('International', '/internasional');
	}

	public function listRegional() {
		return $this->listExternal('Regional', '/regional');
	}

	public function info($id) {
		$data = $this->getCompetition($id);

		return view('competition_info', array_merge($data, [
			'submenu' => '',
		]));
	}

	public function syllabus($id) {
		$data = $this->getCompetition($id);

		return view('competition_syllabus', array_merge($data, [
			'submenu' => '/silabus',
		]));
	}

	public function rules($id) {
		$data = $this->getCompetition($id);

		return view('competition_rules', array_merge($data, [
			'submenu' => '/peraturan',
		]));
	}

	public function openContest($id) {
		$data = $this->getCompetition($id);

		return view('competition_open', array_merge($data, [
			'submenu' => '/open',
		]));
	}

	public function openContestResults($id) {
		$data = $this->getCompetition($id);

		return view('competition_open_results', array_merge($data, [
			'submenu' => '/open-results',
		]));
	}

	public function results($id) {
		helper('score');
		helper('medal');
		helper('link');

		$data = $this->getCompetition($id);
		$competition = $data['competition'];
		$isNational = $data['isNational'];
		$isFinished = $data['isFinished'];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, c.Rank as 'Rank', TeamNo, p.ID as PersonID, c.Province as ProvinceID, p.Name as Name, pr.Name as ProvinceName, s.ID as SchoolID, s.Name as SchoolName, Score, Medal
			from Contestant c
			join Person p on p.ID = c.Person
			left join School s on s.ID = c.School
			left join Province pr on pr.ID = c.Province
			where Competition = ?
			order by -c.Rank desc, ProvinceName asc, SchoolName asc, Name asc
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

		$table = createTable();
		$heading = array(
			['data' => '#', 'class' => 'col-centered'],
			'Nama',
			'Sekolah'
		);
		if ($isNational) {
			$heading[] = ['data' => 'Provinsi', 'class' => 'col-province'];
			foreach ($tasks as $t) {
				$heading[] = ['data' => $t['Alias'], 'class' => 'col-centered'];
			}
			$heading[] = ['data' => 'Total', 'class' => 'col-centered'];
		}
		$heading[] = 'Medali';
		$table->setHeading($heading);

		foreach ($contestants as $c) {
			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => $c['TeamNo'] == 1 ? $c['Rank'] : '', 'class' => 'col-rank ' . $clazz],
				['data' => linkPerson($c['PersonID'], $c['Name']), 'class' => $clazz],
				['data' => linkSchool($c['SchoolID'], $c['SchoolName']), 'class' => 'col-school ' . $clazz]
			);
			if ($isNational) {
				$row[] = ['data' => linkProvince($c['ProvinceID'], $c['ProvinceName']), 'class' => $clazz];
				foreach ($tasks as $t) {
					$score = $taskScores[$c['ID']][$t['Alias']] ?? null;

					$style = '';
					if (!$isFinished) {
						$style = 'background-color: ' . $this->getScoreColor($score, 1);
					}

					$row[] = ['data' => $taskScores[$c['ID']][$t['Alias']] ?? '', 'class' => 'col-score ' . $clazz, 'style' => $style];
				}
				$row[] = ['data' => formatScore($c['Score'], $data['competition']['ScorePr']), 'class' => 'col-score ' . $clazz];
			}
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
		helper('link');

		$data = $this->getCompetition($id);

		$medals = $this->getProvinceMedals(null, $id);

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

		return view('competition_provinces', array_merge($data, [
			'submenu' => '/provinsi',
			'table' => $table->generate()
		]));
	}

	private function listExternal($level, $submenu) {
		helper('link');

		$competitions = $this->getCompetitions(null, $level);

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-striped table-bordered">'
		]);

		$table->setHeading(['data' => '#', 'class' => 'col-order'], 'Nama', 'Peserta Indonesia');

		$competitionsCount = count($competitions);
		for ($i = 0; $i < $competitionsCount; $i++) {
			$c = $competitions[$i];
			$table->addRow(
				$competitionsCount-$i,
				linkCompetition($c['ID'], $c['Name']),
				['data' => $c['Contestants'], 'class' => 'col-id-contestants'],
			);
		}

		return view('competitions', [
			'menu' =>'competition',
			'submenu' => $submenu,
			'table' => $table->generate()
		]);
	}

	private function getCompetition($id) {
		helper('date');

		$competitions = $this->getCompetitions($id, null);

		if (empty($competitions)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$competition = $competitions[0];

		$data = [
			'menu' => 'competition',
			'competition' => $competition,
			'isNational' => $competition['Level'] == 'National',
			'isFinished' => $competition['Finished'] == 'Y',
			'dates' => formatDateRange($competition['DateBegin'], $competition['DateEnd']),
		];

		$competitions = $this->db->query(<<<QUERY
			select ID, Year from Competition
			where Level = ?
			and Year in (?, ?)
		QUERY, [$competition['Level'], $competition['Year']-1, $competition['Year']+1])->getResultArray();

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

	private function getScoreColor($score, $problemCount) {
		if ($score == null) {
		  return 'inherit';
		}
		$hue = ($score * 120.0) / (100.0 * $problemCount);
		return 'hsl(' . $hue . ', 80%, 60%)';
	}
}
