<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
	<div class="bp3-card subcontent">
		<h3><?= $person['Name'] ?></h3>
		<hr />

		<div class="bp3-card bp3-elevation-1 statistics-person-summary">
			<?= $medalsTable ?>
		</div>

		<?php if ($internationalTable) : ?>
			<h4>Internasional</h4>
			<?= $internationalTable ?>
		<?php endif ?>

		<?php if ($regionalTable) : ?>
			<h4>Regional</h4>
			<?= $regionalTable ?>
		<?php endif ?>

		<?php if ($nationalTable) : ?>
			<h4>Nasional</h4>
			<?= $nationalTable ?>
		<?php endif ?>

		<?php if (isset($committeeTable) && $committeeTable) : ?>
			<hr />
			<h4>Asisten Juri</h4>
			<?= $committeeTable ?>
		<?php endif ?>
	</div>
<?= $this->endSection() ?>
