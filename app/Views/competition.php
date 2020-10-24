<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2><?= $competitionName ?></h2>

	<div class="bp3-button-group">
		<a role="button" href="<?= $contentUrl ?>" class="bp3-button <?= $submenu == 'info' ? 'bp3-active' : '' ?>">Informasi</a>
		<a role="button" href="<?= $contentUrl ?>/hasil" class="bp3-button <?= $submenu == 'result' ? 'bp3-active' : '' ?>">Hasil</a>
	</div>

	<div class="bp3-card subcontent">
		<?= $this->renderSection('subcontent') ?>
	</div>

<?= $this->endSection() ?>
