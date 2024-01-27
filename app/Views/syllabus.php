<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Silabus</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/silabus/kota" class="bp3-button <?= $submenu == '/kota' ? 'bp3-active' : '' ?>">OSN-K</a>
		<a role="button" href="/silabus" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">OSN</a>
  </div>
  
	<?= $this->renderSection('subcontent') ?>
<?= $this->endSection() ?>
