<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<div class="bp3-card home-info">
  <p>Situs ini merupakan pusat informasi mengenai <b>Kompetisi Sains Nasional (KSN) bidang Informatika</b>, termasuk KSN-P dan KSN-K.</p>
  <p>(Sebelum tahun 2020 disebut <b>OSN</b>, <b>OSP</b>, dan <b>OSK</b>.)</p>
  <p>Kompetisi Sains Nasional diadakan oleh <a href="https://pusatprestasinasional.kemdikbud.go.id/">Pusat Prestasi Nasional</a>, Kementerian Pendidikan dan Kebudayaan Indonesia.</p>
</div>
<hr />
<table>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/persiapan'">
        <h3 class="bp3-heading">Persiapan</h3>
        <p>Persiapkan diri Anda dalam menghadapi KSN Informatika.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/silabus'">
        <h3 class="bp3-heading">Silabus</h3>
        <p>Ketahui materi apa saja yang akan diujikan pada KSN Informatika.</p>
      </div>
    </td>
  </tr>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/arsip'">
        <h3 class="bp3-heading">Arsip Soal</h3>
        <p>Berlatih soal-soal dari kompetisi-kompetisi tahun-tahun terdahulu.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/statistik'">
        <h3 class="bp3-heading">Statistik</h3>
        <p>Lihat statistik peserta, provinsi, dan nasional.</p>
      </div>
    </td>
  </tr>
</table>

<div class="bp3-callout home-footer">
  <p><small><i>Situs ini disusun oleh <a href="https://alumni.toki.id"><b>Ikatan Alumni Tim Olimpiade Komputer Indonesia</b></a> (IA TOKI).</small></i>
  <i><small>Ingin memperbaiki informasi/data? Laporkan pada <a href="http://github.com/ia-toki/ksn-web"><b>github.com/ia-toki/ksn-web</b></a></small></i>.</p>
</div>

<?= $this->endSection() ?>
