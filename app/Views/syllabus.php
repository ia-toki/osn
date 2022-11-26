<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Silabus</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/silabus" class="bp3-button bp3-active">OSN</a>
  </div>
  
	<?= $this->renderSection('subcontent') ?>
<?= $this->endSection() ?>
