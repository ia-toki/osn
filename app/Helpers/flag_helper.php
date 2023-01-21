<?php

define('MONTH_NAMES', [
	'',
	'Januari',
	'Februari',
	'Maret',
	'April',
	'Mei',
	'Juni',
	'Juli',
	'Agustus',
	'September',
	'Oktober',
	'November',
	'Desember',
]);

function createFlag($countryCode) {
	return '<img class="flag" src="/flags/' . $countryCode . '.svg"/>';
}
