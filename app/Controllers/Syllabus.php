<?php namespace App\Controllers;

class Syllabus extends BaseController {
	public function national() {
		return view('syllabus_national', [
			'menu' =>'syllabus',
		]);
	}
}
