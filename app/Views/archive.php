<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<h2>Arsip Soal</h2>
<div class="bp3-button-group section">
	<a role="button" href="/arsip/kota" class="bp3-button <?= $submenu == '/kota' ? 'bp3-active' : '' ?>">KSN-K</a>
	<a role="button" href="/arsip/provinsi" class="bp3-button <?= $submenu == '/provinsi' ? 'bp3-active' : '' ?>">KSN-P</a>
	<a role="button" href="/arsip" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">KSN</a>
</div>

<?= $this->renderSection('subcontent') ?>

<?= $this->endSection() ?>
