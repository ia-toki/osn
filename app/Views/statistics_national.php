<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card subcontent">
		<h3>Indonesia</h3>
		<hr />
		<div class="bp3-callout bp3-intent-warning section">
			Kunjungi juga <a href="https://stats.ioinformatics.org/results/IDN"><b>situs statistik Indonesia pada IOI</b></a>.
		</div>

		<div class="bp3-card bp3-elevation-1 statistics-person-summary">
			<?= $table ?>
		</div>
	</div>
<?= $this->endSection() ?>
