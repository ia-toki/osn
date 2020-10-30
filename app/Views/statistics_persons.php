<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
	<form method="POST" class="section">
		<div class="bp3-input-group">
			<span class="bp3-icon bp3-icon-search"></span>
			<input name="name" class="bp3-input" type="search" placeholder="Cari (min. 3 karakter)" <?= $nameFilter ? 'autofocus value="' . $nameFilter . '"' : '' ?> dir="auto" />
		</div>
	</form>
		<?php if ($nameFilter) : ?>
			
	<?php else : ?>
		<div class="bp3-callout bp3-intent-warning section">
			Hanya menampilkan 100 peringkat teratas.
		</div>
	<?php endif; ?>
	<?= $table ?>
<?= $this->endSection() ?>
