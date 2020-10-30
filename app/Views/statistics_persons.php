<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-callout bp3-intent-warning section">
		Hanya menampilkan 100 peringkat teratas.
	</div>
	<?= $table ?>
<?= $this->endSection() ?>
