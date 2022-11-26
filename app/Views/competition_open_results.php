<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/open_results.php')): ?>
		<?= $this->include($competition['ID'] . '/open_results'); ?>
	<?php else: ?>
		<div class="bp3-callout bp3-intent-danger">
			<p><em>Informasi tidak tersedia.</em></p>
		</div>
	<?php endif; ?>
<?= $this->endSection() ?>
