<?php

function createTable() {
	$table = new \CodeIgniter\View\Table();
	$table->setTemplate([
		'table_open' => '<table class="table table-bordered">'
	]);
	return $table;
}

function getMedalClass($medal) {
	if (!$medal) {
		return '';
	}
	$map = array('G' => 'gold', 'S' => 'silver', 'B' => 'bronze', 'HM' => 'hm');
	if (!isset($map[$medal])) {
		return '';
	}
	$clazz = $map[$medal];
	return 'medal--' . $clazz;
}

function getMedalName($medal) {
	if (!$medal) {
		return '';
	}
	$map = array('G' => 'Emas', 'S' => 'Perak', 'B' => 'Perunggu', 'HM' => 'Juara Harapan');
	return $map[$medal] ?? '';
}

function getMedalNameEnglish($medal) {
	if (!$medal) {
		return '';
	}
	$map = array('G' => 'Gold', 'S' => 'Silver', 'B' => 'Bronze');
	return $map[$medal] ?? '';
}

function createMedalHeading($prefix) {
	return ['data' => $prefix, 'class' => 'col-centered', 'colspan' => '4'];
}

function createMedalCells($medal, $prefix, $clazz) {
	$cl = $clazz ?? 'col-medals';
	return array(
		['data' => $medal[$prefix . 'Golds'] ?? '-', 'class' => $cl . ' ' . getMedalClass('G')],
		['data' => $medal[$prefix . 'Silvers'] ?? '-', 'class' => $cl . ' ' . getMedalClass('S')],
		['data' => $medal[$prefix . 'Bronzes'] ?? '-', 'class' => $cl . ' ' . getMedalClass('B')],
		['data' => $medal[$prefix . 'Participants'] ?? '-', 'class' => $cl]
	);
}
