<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>
		<?php if (isset($prevCompetition)): ?>
			<a role="button" href="/<?= $prevCompetition['ID'] ?><?= $submenu ?>" class="bp3-button bp3-small bp3-icon-chevron-left"></a>
		<?php endif ?>
		<?= $competition['Name'] ?>
		<?php if (isset($nextCompetition)): ?>
			<a role="button" href="/<?= $nextCompetition['ID'] ?><?= $submenu ?>" class="bp3-button bp3-small bp3-icon-chevron-right"></a>
		<?php endif ?>
	</h2>

	<div class="bp3-button-group">
		<a role="button" href="/<?= $competition['ID'] ?>" class="bp3-button <?= $submenu == '' ? 'bp3-active' : '' ?>">Informasi</a>
		<a role="button" href="/<?= $competition['ID'] ?>/hasil" class="bp3-button <?= $submenu == '/hasil' ? 'bp3-active' : '' ?>">Hasil Individu</a>
		<a role="button" href="/<?= $competition['ID'] ?>/provinsi" class="bp3-button <?= $submenu == '/provinsi' ? 'bp3-active' : '' ?>">Hasil Provinsi</a>
	</div>

	<div class="bp3-card subcontent">
		<?= $this->renderSection('subcontent') ?>
	</div>

<?= $this->endSection() ?>
