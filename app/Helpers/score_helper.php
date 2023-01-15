<?php

function formatScore($score, $precision) {
	if ($precision == 0) {
		return substr($score, 0, strlen($score)-3);
	}
	return $score;
}

function getScoreCss($score) {
	if ($score == '') {
		return '';
	}

	$hue = $score * 120.0 / 100.0;
	return 'background-color: hsl(' . $hue . ', 80%, 60%)';
}
