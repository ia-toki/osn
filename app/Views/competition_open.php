<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/open.php')): ?>
		<?= $this->include($competition['ID'] . '/open'); ?>
	<?php endif; ?>
<?= $this->endSection() ?>
