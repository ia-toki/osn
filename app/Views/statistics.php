<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Statistik</h2>
	<div class="bp3-button-group header-section">
		<a role="button" href="/statistik" class="bp3-button <?= $submenu == '' ? 'bp3-active' : '' ?>">Provinsi</a>
		<a role="button" href="/statistik/peserta" class="bp3-button <?= $submenu == '/peserta' ? 'bp3-active' : '' ?>">Individu</a>
	</div>

	<?= $this->renderSection('subcontent') ?>

<?= $this->endSection() ?>
