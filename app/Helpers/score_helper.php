<?php

function formatScore($score, $precision) {
	if ($precision == 0) {
		return substr($score, 0, strlen($score)-3);
	}
	return $score;
}
