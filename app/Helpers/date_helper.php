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

function formatDateRange($beginDate, $endDate) {
	if (!$beginDate || !$endDate) {
		return '';
	}

	setlocale(LC_TIME, 'id_ID');

	$beginDate = date_create($beginDate);
	$endDate = date_create($endDate);

	$beginMonth = $beginDate->format('n');
	$beginDay = $beginDate->format('j');
	$beginYear = $beginDate->format('Y');

	$endMonth = $endDate->format('n');
	$endDay = $endDate->format('j');

	if ($beginMonth == $endMonth) {
		return $beginDay . '&ndash;' . $endDay . ' ' . MONTH_NAMES[$endMonth] . ' ' . $beginYear;
	}

	return $beginDay . ' ' . MONTH_NAMES[$beginMonth] . ' &ndash; ' . $endDay . ' ' . MONTH_NAMES[$endMonth] . ' ' . $beginYear;
}
