<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$q = $this->db->table('Competition c');
		$q->join('Province p', 'p.ID = c.Host');
		$q->select('c.Name as Name, p.Name as HostName, City, DateBegin, DateEnd, Contestants, Provinces');
		$q->orderBy('Year', 'DESC');
		$competitions = $q->get()->getResultArray();

		$table = new \CodeIgniter\View\Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-striped table-bordered">'
		]);

		$table->setHeading('#', 'Nama', 'Tuan Rumah', 'Kota', 'Waktu', 'Peserta', 'Provinsi');

		$competitionsCount = count($competitions);
		for($i = 0; $i < $competitionsCount; $i++)
		{
			$c = $competitions[$i];
			$table->addRow(
				$competitionsCount-$i,
				$c['Name'],
				$c['HostName'],
				$c['City'],
				date_format(date_create($c['DateBegin']), 'd M Y') . ' &ndash; ' . date_format(date_create($c['DateEnd']), 'd M Y'),
				$c['Contestants'],
				$c['Provinces']
			);
		}

		return view('welcome_message', ['table' => $table->generate(), 'competitions' => $competitions]);
	}
}
