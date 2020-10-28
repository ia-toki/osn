<?php

function linkCompetition($id, $name) {
	return '<a href="/' . $id . '/hasil">' . $name . '</a>';
}

function linkProvince($id, $name) {
	return '<a href="/statistik/provinsi/' . $id . '">' . $name . '</a>';
}

function linkPerson($id, $name) {
	return '<a href="/statistik/peserta/' . $id . '">' . $name . '</a>';
}
