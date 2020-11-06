<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<h2>Persiapan</h2>
<p>Berikut ini adalah sumber-sumber yang dapat Anda manfaatkan untuk mempersiapkan diri menghadapi KSN-K, KSN-P, dan KSN bidang Informatika/Komputer, yang disusun oleh Ikatan Alumni TOKI.<p>
<p>Dengan ini, diharapkan seluruh siswa memiliki kesempatan yang sama dalam berkompetisi, terutama yang mungkin belum memiliki akses fasilitas seperti guru, senior yang pernah menjuarai olimpiade, ataupun dana untuk mengikuti pelatihan KSN.</p>
<hr />
<div class="bp3-button-group section">
	<a role="button" href="/persiapan" class="bp3-button <?= $submenu == '/' ? 'bp3-active' : '' ?>">KSN-K / KSN-P</a>
	<a role="button" href="/persiapan/nasional" class="bp3-button <?= $submenu == '/nasional' ? 'bp3-active' : '' ?>">KSN</a>
	<a role="button" href="/persiapan/lain-lain" class="bp3-button <?= $submenu == '/lain-lain' ? 'bp3-active' : '' ?>">Lain-Lain</a>
</div>

<div class="bp3-card subcontent">
	<?= $this->renderSection('subcontent') ?>
</div>

<?= $this->endSection() ?>
