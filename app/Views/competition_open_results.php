<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/open_results.csv')): ?>
		<?php
			$csv = fopen(APPPATH . 'Views/' . $competition['ID'] . '/open_results.csv', 'r');
			$header = fgetcsv($csv);
			$problems = array_splice($header, 5, count($header)-5-2);
			$countries = [
				'ARM' => 'Armenia',
				'AZE' => 'Azerbaijan',
				'BGD' => 'Bangladesh',
				'EGY' => 'Egypt',
				'GEO' => 'Georgia',
				'IND' => 'India',
				'IDN' => 'Indonesia',
				'ITA' => 'Italy',
				'JPN' => 'Japan',
				'LUX' => 'Luxembourg',
				'MYS' => 'Malaysia',
				'MNG' => 'Mongolia',
				'NZL' => 'New Zealand',
				'POL' => 'Poland',
				'SGP' => 'Singapore',
				'THA' => 'Thailand',
				'TKM' => 'Turkmenistan',
				'VNM' => 'Viet Nam'
			];
			$medals = [
				'G' => 'Gold',
				'S' => 'Silver',
				'B' => 'Bronze',
			];

			function get_score_css($score) {
				if ($score == '') {
					return '';
				}

				$hue = $score * 120.0 / 100.0;
				return 'background-color: hsl(' . $hue . ', 80%, 60%)';
			}
		?>

		<div class="bp3-callout bp3-intent-warning">
			<p>*Medals are based on the official contest cutoffs.</p>
		</div>

		<br />

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-rank">#</th>
					<th class="col-name">TLX Username</th>
					<th class="col-name">Name</th>
					<th class="col-province">Country</th>
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
							<td class="col-score" style="<?= get_score_css($score) ?>"><?= $score ?></td>
						<?php endforeach; ?>

						<td class="col-score"><?= array_shift($row) ?></td>
						<td><?php
							$medal = array_shift($row);
							echo isset($medals[$medal]) ? $medals[$medal] : $medal;
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
