<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/open_results.php')): ?>
		<?= $this->include($competition['ID'] . '/open_results'); ?>
	<?php endif; ?>
<?= $this->endSection() ?>
