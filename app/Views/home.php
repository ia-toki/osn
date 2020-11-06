<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<div class="bp3-card home-info">
  <p><b>KSN</b> (Kompetisi Sains Nasional) merupakan kompetisi tahunan tingkat SMA/sederajat yang diadakan oleh <a href="https://pusatprestasinasional.kemdikbud.go.id/">Pusat Prestasi Nasional</a>, Kementerian Pendidikan dan Kebudayaan Indonesia. Salah satu bidang yang dilombakan di KSN merupakan bidang <b>informatika/komputer</b>. Pada bidang ini, siswa diuji kemampuan menyelesaikan masalah (<i>problem solving</i>) dan berpikir logis melalui soal-soal pemrograman. </p>
  <p>Untuk dapat bertanding di KSN tingkat nasional, siswa harus dikirimkan melalui pihak sekolah ke KSN tingkat kota/kabupaten (<b>KSN-K</b>) terlebih dahulu. Kemudian, siswa-siswi terbaik tingkat kota akan ditandingkan di tingkat provinsi (<b>KSN-P</b>) dan kemudian nasional (<b>KSN</b>).</p> 
  <p>(Sebelum tahun 2020, kompetisi ini disebut <b>OSK</b>, <b>OSP</b>, dan <b>OSN</b>.)</p>
</div>
<hr />
<table>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/persiapan'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-form"></span>&nbsp;&nbsp;Persiapan</h3>
        <p>Persiapkan diri Anda dalam menghadapi KSN Informatika.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/silabus'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-properties"></span>&nbsp;&nbsp;Silabus</h3>
        <p>Ketahui materi apa saja yang akan diujikan pada KSN Informatika.</p>
      </div>
    </td>
  </tr>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/arsip'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-duplicate"></span>&nbsp;&nbsp;Arsip Soal</h3>
        <p>Berlatih soal-soal dari kompetisi-kompetisi tahun-tahun terdahulu.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/statistik'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-series-search"></span>&nbsp;&nbsp;Statistik</h3>
        <p>Lihat statistik peserta, sekolah, provinsi, dan nasional.</p>
      </div>
    </td>
  </tr>
</table>

<?= $this->endSection() ?>
