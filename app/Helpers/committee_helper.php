<?php

define('COMMITTEE_TITLES', [
	'SC' => 'Komite Soal',
	'TC' => 'Komite Teknis',
	'OC' => 'Komite Acara',
	'PJJ' => 'Koordinator PJJ',
	'OPEN' => 'Koordinator OSN Terbuka',
	'PJJOPEN' => 'Koordinator PJJ & OSN Terbuka',
]);

function getCommitteeTitles() {
	return COMMITTEE_TITLES;
}

function getCommitteeTitle($role, $isChair) {
	return COMMITTEE_TITLES[$role] . ($isChair ? ' (Ketua)' : '');
}

function getCommitteeRoles() {
	return array_keys(COMMITTEE_TITLES);
}
