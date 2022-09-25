<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card">
		<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/rules.php')): ?>
			<?= $this->include($competition['ID'] . '/rules'); ?>
		<?php endif; ?>
	</div>
<?= $this->endSection() ?>
