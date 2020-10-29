<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Silabus</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/silabus" class="bp3-button bp3-active">Tingkat Nasional (KSN)</a>
  </div>
  
  <div class="bp3-card subcontent">
		<?= $this->renderSection('subcontent') ?>
	</div>
<?= $this->endSection() ?>
