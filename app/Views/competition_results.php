<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
	<?php if ($competition['ID'] == 'OSN2023') : ?>
		<div class="bp3-callout bp3-intent-warning">
			<p>Berdasarkan peraturan BPTI, detail hasil setiap bidang hanya boleh dirilis beberapa hari setelah pengumuman resmi. 🙏</p>
		</div>
		<br />
	<?php endif; ?>
	<?php if (!$isDataComplete) : ?>
		<div class="bp3-callout bp3-intent-warning">
			<p><b>Data tidak tersedia / tidak lengkap</b>. Memiliki data? Laporkan pada <b><a href="https://github.com/ia-toki/osn">github.com/ia-toki/osn</a></b>.</p>
		</div>
		<br />
	<?php endif; ?>
	<?= $table ?>
<?= $this->endSection() ?>
