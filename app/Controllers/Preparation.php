<?php namespace App\Controllers;

class Preparation extends BaseController {
	public function province() {
		return view('preparation_province', [
			'menu' => 'preparation',
			'submenu' => '/'
		]);
	}
	
	public function national() {
		return view('preparation_national', [
			'menu' => 'preparation',
			'submenu' => '/nasional'
		]);
	}
	
	public function others() {
		return view('preparation_others', [
			'menu' => 'preparation',
			'submenu' => '/lain-lain'
		]);
	}
}
