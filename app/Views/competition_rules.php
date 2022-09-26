<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/rules.php')): ?>
		<?= $this->include($competition['ID'] . '/rules'); ?>
	<?php endif; ?>
<?= $this->endSection() ?>
