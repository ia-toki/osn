<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if (!$isDataComplete) : ?>
		<div class="bp3-callout bp3-intent-warning">
			<p><b>Data tidak tersedia / tidak lengkap</b>. Memiliki data? Laporkan pada <b><a href="https://github.com/ia-toki/osn">github.com/ia-toki/osn</a></b>.</p>
		</div>
		<br />
	<?php endif; ?>
	<?= $table ?>
<?= $this->endSection() ?>
