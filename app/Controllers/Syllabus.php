<?php namespace App\Controllers;

class Syllabus extends BaseController {
	public function national() {
		return view('syllabus_national', [
			'menu' => 'syllabus',
			'submenu' => '/'
		]);
	}

	public function city() {
		return view('syllabus_city', [
			'menu' => 'syllabus',
			'submenu' => '/kota'
		]);
	}
}
