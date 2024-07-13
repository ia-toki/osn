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
				linkCompetitionInfo($c['ID'], $c['Name']) . ($c['DataComplete'] == 'N' ? ' *' : ''),
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
		helper('link');
		helper('committee');

		$data = $this->getCompetition($id);
		$committee = $this->getCompetitionCommittee($id);

		$data['committee'] = array();
		foreach (getCommitteeRoles() as $role) {
			$data['committee'][$role] = [
				'members' => array(),
			];
		}

		foreach ($committee as $c) {
			$role = $c['Role'];
			if (!isset($data['committee'][$role])) {
				continue;
			}
			$entry = linkPerson($c['PersonID'], $c['PersonName']);
			if ($c['Chair'] == 'Y') {
				$data['committee'][$role]['chair'] = $entry;
			} else {
				$data['committee'][$role]['members'][] = $entry;
			}
		}
		$data['committeeTitles'] = getCommitteeTitles();

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
		helper('medal');
		helper('score');

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
		$isStarted = $data['isStarted'];
		$isFinished = $data['isFinished'];

		$contestants = $this->db->query(<<<QUERY
			select c.ID as ID, c.Rank as 'Rank', TeamNo, p.ID as PersonID, c.Province as ProvinceID, p.Name as Name, pr.Name as ProvinceName, s.ID as SchoolID, s.Name as SchoolName, Gender, Grade, Score, ScoreMark, Medal
			from Contestant c
			join Person p on p.ID = c.Person
			left join School s on s.ID = c.School
			left join Province pr on pr.ID = c.Province
			where Competition = ?
			order by -c.Rank desc, ProvinceName asc, SchoolName asc, Name asc
		QUERY, [$id])->getResultArray();

		$pastContestants = array();
		if (!$isStarted) {
			$pastContestants = $this->getPastContestants($competition);
		}

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
		);

		if ($this->hasGenderInfo($contestants)) {
			$heading[] = 'J.K.';
		}

		if ($this->hasGradeInfo($contestants)) {
			$heading[] = 'Kls.';
		}

		$heading[] = 'Sekolah';

		if ($isNational) {
			$heading[] = ['data' => 'Provinsi', 'class' => 'col-province'];
			foreach ($tasks as $t) {
				$heading[] = ['data' => $t['Alias'], 'class' => 'col-centered'];
			}

			if ($isStarted) {
				$heading[] = ['data' => 'Total', 'class' => 'col-centered'];
			} else {
				$heading[] = 'Veteran?';
			}
		}

		if ($isFinished) {
			$heading[] = 'Medali';
		}

		$table->setHeading($heading);

		foreach ($contestants as $c) {
			$clazz = getMedalClass($c['Medal']);

			$row = array(
				['data' => $c['TeamNo'] == 1 ? $c['Rank'] : '', 'class' => 'col-rank ' . $clazz],
				['data' => linkPerson($c['PersonID'], $c['Name']), 'class' => $clazz],
			);

			if ($this->hasGenderInfo($contestants)) {
				$row[] = ['data' => $c['Gender'], 'class' => 'col-gender ' . $clazz];
			}

			if ($this->hasGradeInfo($contestants)) {
				$row[] = ['data' => $c['Grade'], 'class' => 'col-grade ' . $clazz];
			}

			$row[] = ['data' => linkSchool($c['SchoolID'], $c['SchoolName']), 'class' => 'col-school ' . $clazz];

			if ($isNational) {
				$row[] = ['data' => linkProvince($c['ProvinceID'], $c['ProvinceName']), 'class' => $clazz];
				foreach ($tasks as $t) {
					$score = $taskScores[$c['ID']][$t['Alias']] ?? null;

					$style = '';
					if (!$isFinished) {
						$style = getScoreCss($score);
					}

					$row[] = ['data' => $taskScores[$c['ID']][$t['Alias']] ?? '', 'class' => 'col-score ' . $clazz, 'style' => $style];
				}
				if ($isStarted) {
					$row[] = ['data' => formatScore($c['Score'], $data['competition']['ScorePr']) . formatScoreMark($c['ScoreMark']), 'class' => 'col-score ' . $clazz];
				} else {
					$row[] = join(', ', $pastContestants[$c['PersonID']] ?? []);
				}
			}

			if ($isFinished) {
				$row[] = ['data' => getMedalName($c['Medal']), 'class' => 'col-medal ' . $clazz];
			}

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
		helper('medal');
		helper('flag');

		$competitions = $this->getCompetitions(null, $level);
		$medals = $this->getCompetitionMedals($level);

		$medalsByCompetition = array();
		foreach ($medals as $row) {
			if (!isset($medalsByCompetition)) {
				$medalsByCompetition[$row['ID']] = array();
			}
			$medalsByCompetition[$row['ID']][$row['Medal']] = $row['Cnt'];
		}

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-striped table-bordered">'
		]);

		$table->setHeading(
			['data' => '#', 'class' => 'col-order'],
			['data' => 'Nama', 'class' => 'col-external-competition-name'],
			'Tuan Rumah',
			'Catatan',
			['data' => 'Hasil Peserta Indonesia', 'colspan' => 4]
		);

		$competitionsCount = count($competitions);
		for ($i = 0; $i < $competitionsCount; $i++) {
			$c = $competitions[$i];
			$table->addRow(
				$competitionsCount-$i,
				linkCompetition($c['ID'], $c['Name']),
				createFlag($c['HostCountryCode']) . $c['HostCountryName'],
				$c['Note'],
				...createMedalCells($medalsByCompetition[$c['ID']], '', null)
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
			'isStarted' => $competition['Started'] == 'Y',
			'isFinished' => $competition['Finished'] == 'Y',
			'isDataComplete' => $competition['DataComplete'] == 'Y',
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

	private function getPastContestants($competition) {
		$contestants = $this->db->query(<<<QUERY
			select c.Person as PersonID, comp.Year as Year
			from Contestant c
			join Person p on p.ID = c.Person
			join Competition comp on comp.ID = c.Competition
			where comp.Level = ? and comp.Year < ?
			and c.Person in (select Person from Contestant where Competition = ?)
			order by Year desc
		QUERY, [$competition['Level'], $competition['Year'], $competition['ID']])->getResultArray();

		$result = array();
		foreach ($contestants as $c) {
			if (!isset($result[$c['PersonID']])) {
				$result[$c['PersonID']] = array();
			}
			$result[$c['PersonID']][] = $c['Year'];
		}
		return $result;
	}

	private function hasGenderInfo($contestants) {
		foreach ($contestants as $c) {
			if ($c['Gender']) {
				return true;
			}
		}
		return false;
	}

	private function hasGradeInfo($contestants) {
		foreach ($contestants as $c) {
			if ($c['Grade']) {
				return true;
			}
		}
		return false;
	}
}
