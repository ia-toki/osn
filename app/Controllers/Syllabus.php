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

	public function province() {
		return view('syllabus_province', [
			'menu' => 'syllabus',
			'submenu' => '/provinsi'
		]);
	}
}
