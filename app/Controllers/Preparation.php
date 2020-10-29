<?php namespace App\Controllers;

class Preparation extends BaseController {
	public function index() {
		return view('preparation', [
			'menu' =>'preparation',
		]);
	}
}
