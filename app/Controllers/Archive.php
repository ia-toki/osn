<?php namespace App\Controllers;

class Archive extends BaseController {
	public function national() {
		return view('archive_national', [
			'menu' =>'archive',
			'submenu' =>'/',
		]);
	}

	public function province() {
		return view('archive_province', [
			'menu' =>'archive',
			'submenu' =>'/provinsi',
		]);
	}

	public function city() {
		return view('archive_city', [
			'menu' =>'archive',
			'submenu' =>'/kota',
		]);
	}
}
