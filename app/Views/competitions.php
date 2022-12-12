<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Olimpiade</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/olimpiade" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">Nasional</a>
		<a role="button" href="/olimpiade/regional" class="bp3-button <?= $submenu == '/regional' ? 'bp3-active' : '' ?>">Regional</a>
		<a role="button" href="/olimpiade/internasional" class="bp3-button <?= $submenu == '/internasional' ? 'bp3-active' : '' ?>">Internasional</a>
	</div>
	
	<?php if ($submenu == '/internasional') : ?>
		<div class="bp3-callout bp3-intent-warning section">
			<p>Kunjungi juga <a href="https://ioinformatics.org"><b>situs resmi IOI</b></a>.</p>
		</div>
	<?php endif; ?>

	<?= $table ?>
<?= $this->endSection() ?>
