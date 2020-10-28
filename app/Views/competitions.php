<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Kompetisi</h2>
	<div class="bp3-button-group header-buttons">
		<a role="button" href="/kompetisi" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">Nasional</a>
		<a role="button" href="/kompetisi/regional" class="bp3-button <?= $submenu == '/regional' ? 'bp3-active' : '' ?>">Regional</a>
		<a role="button" href="/kompetisi/internasional" class="bp3-button <?= $submenu == '/internasional' ? 'bp3-active' : '' ?>">Internasional</a>
	</div>
	<?= $table ?>
<?= $this->endSection() ?>
