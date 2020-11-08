<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card">
		<h3>Informasi Umum</h3>
		<table class="table table-bordered table-competition-info">
			<tbody>
				<tr><th>Tempat</th><td><?= $competition['City'] ?><?= $competition['HostName'] ? ', ' . $competition['HostName'] : '' ?></td></tr>
				<tr><th>Waktu</th><td> <?= date_format(date_create($competition['DateBegin']), 'd M Y') . ' &ndash; ' . date_format(date_create($competition['DateEnd']), 'd M Y') ?></td></tr>
				<?php if ($competition['Website']) : ?>
					<tr><th>Situs</th><td><a href="<?= $competition['Website'] ?>"><?= $competition['Website'] ?></a></td></tr>
				<?php endif ?>
				<?php if ($competition['Contestants']) : ?>
					<tr><th>Peserta</th><td><?= $competition['Contestants'] ?></td></tr>
				<?php endif ?>
				<?php if ($competition['Provinces']) : ?>
					<tr><th>Provinsi</th><td><?= $competition['Provinces'] ?></td></tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>
<?= $this->endSection() ?>
