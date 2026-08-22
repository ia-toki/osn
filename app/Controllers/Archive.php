<?php namespace App\Controllers;

class Archive extends BaseController {
	public function index() {
		return view('archive', [
			'menu' =>'archive',
		]);
	}
}
