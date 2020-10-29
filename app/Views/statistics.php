<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Statistik</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/statistik" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">Peserta</a>
		<a role="button" href="/statistik/provinsi" class="bp3-button <?= $submenu == '/provinsi' ? 'bp3-active' : '' ?>">Provinsi</a>
	</div>

	<?= $this->renderSection('subcontent') ?>

<?= $this->endSection() ?>
