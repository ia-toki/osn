<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/open_results.csv')): ?>
		<?php
			$csv = fopen(APPPATH . 'Views/' . $competition['ID'] . '/open_results.csv', 'r');
			$header = fgetcsv($csv);
			$problems = array_splice($header, 5, count($header)-5-2);
			$countries = [
				'AFG' => 'Afghanistan',
				'ARG' => 'Argentina',
				'ARM' => 'Armenia',
				'AUS' => 'Australia',
				'AZE' => 'Azerbaijan',
				'BEL' => 'Belgium',
				'BGD' => 'Bangladesh',
				'BGR' => 'Bulgaria',
				'BIH' => 'Bosnia and Herzegovina',
				'BLR' => 'Belarus',
				'BRA' => 'Brazil',
				'CAN' => 'Canada',
				'CHN' => 'China',
				'COL' => 'Colombia',
				'CZE' => 'Czech Republic',
				'DNK' => 'Denmark',
				'EGY' => 'Egypt',
				'EST' => 'Estonia',
				'FRA' => 'France',
				'GBR' => 'United Kingdom',
				'GEO' => 'Georgia',
				'GRC' => 'Greece',
				'HKG' => 'Hong Kong',
				'HRV' => 'Croatia',
				'HUN' => 'Hungary',
				'IDN' => 'Indonesia',
				'IND' => 'India',
				'IRN' => 'Iran',
				'ISR' => 'Israel',
				'ITA' => 'Italy',
				'JPN' => 'Japan',
				'KAZ' => 'Kazakhstan',
				'KOR' => 'South Korea',
				'LTU' => 'Lithuania',
				'LUX' => 'Luxembourg',
				'MAR' => 'Morocco',
				'MDA' => 'Moldova',
				'MKD' => 'Macedonia',
				'MNG' => 'Mongolia',
				'MYS' => 'Malaysia',
				'NLD' => 'Netherlands',
				'NZL' => 'New Zealand',
				'PAK' => 'Pakistan',
				'POL' => 'Poland',
				'PHL' => 'Philippines',
				'PRT' => 'Portugal',
				'ROU' => 'Romania',
				'RUS' => 'Russia',
				'SGP' => 'Singapore',
				'SRB' => 'Serbia',
				'SVN' => 'Slovenia',
				'SYR' => 'Syria',
				'THA' => 'Thailand',
				'TJK' => 'Tajikistan',
				'TKM' => 'Turkmenistan',
				'TUN' => 'Tunisia',
				'TUR' => 'Türkiye',
				'TWN' => 'Taiwan',
				'UKR' => 'Ukraine',
				'USA' => 'United States of America',
				'UZB' => 'Uzbekistan',
				'VNM' => 'Viet Nam',
			];
		?>

		<div class="bp3-callout bp3-intent-warning">
			<p>*Medals are based on the official contest cutoffs.</p>
			<p>When there are ties, the user who achieved the score with the shorter duration (sum of Day 1 and Day 2), will be positioned higher in the ranklist.</p>
		</div>

		<br />

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-rank">#</th>
					<th class="col-tlx-username">TLX Username</th>
					<th class="col-name">Name</th>
					<th class="col-country">Country</th>
					<?php foreach ($problems as $problem): ?>
						<th class="col-centered"><?= $problem ?></th>
					<?php endforeach; ?>
					<th class="col-score">Total</th>
					<th>Medal*</th>
				</tr>
			</thead>
			<tbody>
				<?php while (($row = fgetcsv($csv)) != FALSE): ?>
					<tr>
						<td class="col-rank"><?= array_shift($row) ?></td>
						<?php array_shift($row); ?>
						<td><?= array_shift($row) ?></td>
						<td><?= array_shift($row) ?></td>
						<td><?php
							$country_code = array_shift($row);
							echo isset($countries[$country_code]) ? $countries[$country_code] : $country_code;
						?></td>

						<?php foreach ($problems as $problem): ?>
							<?php $score = array_shift($row); ?>
							<td class="col-score" style="<?= getScoreCss($score) ?>"><?= $score ?></td>
						<?php endforeach; ?>

						<td class="col-score"><?= array_shift($row) ?></td>
						<td><?php
							$medal = array_shift($row);
							echo getMedalNameEnglish($medal);
						?></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		<table>

		<?php fclose($csv); ?>
	<?php else: ?>
		<div class="bp3-callout bp3-intent-danger">
			<p><em>Informasi tidak tersedia.</em></p>
		</div>
	<?php endif; ?>
<?= $this->endSection() ?>
