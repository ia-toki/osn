<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card">
		<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/spec.php')): ?>
			<?= $this->include($competition['ID'] . '/spec'); ?>
		<?php endif; ?>
	</div>
<?= $this->endSection() ?>
