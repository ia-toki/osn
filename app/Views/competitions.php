<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	<h2>Kompetisi</h2>
	<div class="bp3-button-group section">
		<a role="button" href="/kompetisi" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">Nasional</a>
		<a role="button" href="/kompetisi/regional" class="bp3-button <?= $submenu == '/regional' ? 'bp3-active' : '' ?>">Regional</a>
		<a role="button" href="/kompetisi/internasional" class="bp3-button <?= $submenu == '/internasional' ? 'bp3-active' : '' ?>">Internasional</a>
	</div>
	
	<?php if ($submenu == '/') : ?>
		<div class="bp3-callout bp3-intent-warning section">
			Ingin memperbaiki data? Laporkan pada <a href="http://github.com/ia-toki/ksn-web"><b>github.com/ia-toki/ksn-web</b></a>.
		</div>
	<?php endif; ?>

	<?php if ($submenu == '/internasional') : ?>
		<div class="bp3-callout bp3-intent-warning section">
			Kunjungi juga <a href="https://ioinformatics.org"><b>situs resmi IOI</b></a>.
		</div>
	<?php endif; ?>

	<?php if ($submenu == '/regional') : ?>
		<div class="bp3-callout bp3-intent-warning section">
			Kunjungi juga <a href="http://apio-olympiad.org"><b>situs resmi APIO</b></a>.
		</div>
	<?php endif; ?>

	<?= $table ?>
<?= $this->endSection() ?>
