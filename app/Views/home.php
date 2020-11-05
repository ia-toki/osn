<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<div class="bp3-card home-info">
  <p>KSN merupakan kompetisi tahunan tingkat SMA/sederajat yang diadakan oleh Pusat Prestasi Nasional, Kementerian Pendidikan dan Kebudayaan Indonesia. Salah satu bidang yang dilombakan di KSN merupakan bidang informatika/komputer. Pada bidang ini, siswa diuji kemampuan menyelesaikan masalah (problem solving) dan berpikir logis melalui soal-soal pemrograman. </p>
  <p>Untuk dapat bertanding di KSN tingkat nasional, siswa harus dikirimkan melalui pihak sekolah di KSN tingkat kota terlebih dahulu. Kemudian, siswa-siswi terbaik tingkat kota akan ditandingkan di tingkat provinsi dan kemudian nasional. </p> 
</div>
<div class="bp3-card home-info">
  <p>Situs ini merupakan pusat informasi mengenai <b>Kompetisi Sains Nasional (KSN) bidang Informatika</b>, yang terdiri atas KSN, KSN-P, dan KSN-K.</p>
  <p>(Sebelum tahun 2020 disebut <b>OSN</b>, <b>OSP</b>, dan <b>OSK</b>.)</p>
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

<hr />
<div class="bp3-callout home-footer">
  <p><small><i>Situs ini dikelola oleh <a href="https://alumni.toki.id"><b>Ikatan Alumni Tim Olimpiade Komputer Indonesia</b></a> (IA TOKI).</small></i>
  <i><small>Ingin memperbaiki informasi/data? Laporkan pada <a href="http://github.com/ia-toki/ksn-web"><b>github.com/ia-toki/ksn-web</b></a></small></i>.</p>
</div>

<?= $this->endSection() ?>
