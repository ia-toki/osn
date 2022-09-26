<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<div class="bp3-card home-info">
  <p><b>OSN</b> (Olimpiade Sains Nasional) merupakan olimpiade tahunan tingkat SMA/sederajat yang diadakan oleh <a href="https://pusatprestasinasional.kemdikbud.go.id/">Pusat Prestasi Nasional</a>, Kementerian Pendidikan dan Kebudayaan Indonesia. Bidang <b>informatika/komputer</b> merupakan salah satu bidang yang dilombakan. Pada bidang ini, siswa diuji kemampuan menyelesaikan masalah (<i>problem solving</i>) dan berpikir logis melalui soal-soal pemrograman. </p>
  <p>Untuk dapat bertanding di OSN tingkat nasional, siswa harus dikirimkan melalui pihak sekolah ke OSN tingkat kota/kabupaten (<b>OSN-K</b>) terlebih dahulu. Kemudian, para siswa terbaik tingkat kota akan ditandingkan di tingkat provinsi (<b>OSN-P</b>) dan kemudian nasional (<b>OSN</b>).</p> 
  <p>Para medalis OSN Informatika akan diseleksi lebih lanjut untuk memilih 4 siswa yang akan mewakili Indonesia pada ajang <a href="https://ioinformatics.org/"><strong>International Olympiad in Informatics</strong></a> (<strong>IOI</strong>).</p>
</div>
<div class="bp3-card home-info">
  <p>(Sebelum tahun 2020, rangkaian olimpiade ini disebut <b>OSK</b>, <b>OSP</b>, dan <b>OSN</b>. Khusus tahun 2020 - 2021, rangkaian olimpiade ini disebut <b>KSN-K</b>, <b>KSN-P</b>, dan <b>KSN</b>. )</p>
</div>
<hr />
<table>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/persiapan'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-form"></span>&nbsp;&nbsp;Persiapan</h3>
        <p>Persiapkan diri Anda dalam menghadapi OSN Informatika.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/silabus'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-properties"></span>&nbsp;&nbsp;Silabus</h3>
        <p>Ketahui materi apa saja yang akan diujikan pada OSN Informatika.</p>
      </div>
    </td>
  </tr>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/arsip'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-duplicate"></span>&nbsp;&nbsp;Arsip Soal</h3>
        <p>Berlatih soal-soal dari olimpiade-olimpiade tahun-tahun terdahulu.</p>
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
