<?php

function formatCompetitionCount($total, $withoutSemifinalists) {
	if ($total === null || $withoutSemifinalists === null || (int) $total === (int) $withoutSemifinalists) {
		return $total;
	}
	return $total . ' &rarr; ' . $withoutSemifinalists;
}
