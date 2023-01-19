<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card">
		<h3>Informasi Umum</h3>
		<table class="table table-bordered table-competition-info">
			<tbody>
				<tr><th>Tempat</th><td><?= $competition['City'] ?><?= $competition['HostName'] ? ', ' . $competition['HostName'] : '' ?></td></tr>
				<tr><th>Waktu</th><td> <?= $dates ?></td></tr>
				<?php if ($competition['Contestants']) : ?>
					<tr><th>Peserta</th><td><?= $competition['Contestants'] ?></td></tr>
				<?php endif ?>
				<?php if ($competition['Provinces']) : ?>
					<tr><th>Provinsi</th><td><?= $competition['Provinces'] ?></td></tr>
				<?php endif ?>
			</tbody>
		</table>

		<hr />

		<h3>Komite Ikatan Alumni</h3>

		<table class="table table-bordered table-competition-info">
			<tbody>
				<?php foreach ($committeeTitles as $role => $title): ?>
					<?php if (!isset($committee[$role]['chair'])) continue; ?>
					<tr rowspan="2">
						<th><?= $title ?></th>
						<td class="col-committee-chair">Ketua</td>
						<td><?= $committee[$role]['chair'] ?></td>
					</tr>
					<?php if (count($committee[$role]['members']) > 0): ?>
						<tr>
							<td></td>
							<td>Anggota</td>
							<td>
								<ul>
									<?php foreach ($committee[$role]['members'] as $member): ?>
										<li><?= $member ?></li>
									<?php endforeach ?>
								</ul>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				
			</tbody>
		</table>

		<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/info.php')): ?>
			<hr />
			<?= $this->include($competition['ID'] . '/info'); ?>
		<?php endif; ?>
	</div>
<?= $this->endSection() ?>
