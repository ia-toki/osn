<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card subcontent">
		<h3><?= $province['Name'] ?></h3>
		<hr />
		<div class="bp3-card bp3-elevation-1 statistics-province-summary">
			<?= $medalsTable ?>
		</div>

		<?= $table ?>
	</div>
<?= $this->endSection() ?>
