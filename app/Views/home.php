<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<div class="bp3-callout bp3-intent-primary">
  <p>Silabus <a href="/silabus/kota">OSN-K</a>, <a href="/silabus/provinsi">OSN-P</a>, dan <a href="/silabus">OSN</a> 2025 sudah dirilis.</p>
</div>

<br />

<div class="bp3-card">
  <p><b>OSN</b> (Olimpiade Sains Nasional) merupakan olimpiade tahunan tingkat SMA/sederajat yang diadakan oleh:</p>
  <ul>
    <li><a href="https://bpti.kemdikbud.go.id/"><strong>Balai Pengembangan Talenta Indonesia</strong> (BPTI)</a> (sebelumnya <a href="https://pusatprestasinasional.kemdikbud.go.id/"><strong>Pusat Prestasi Nasional</strong> (Puspresnas)</a>, sebelumnya Direktorat SMA), Kemendikbudristek Republik Indonesia,</li>
  </ul>
  <p>dan didukung oleh <a href="https://alumni.toki.id"><strong>Ikatan Alumni TOKI</strong></a> (Tim Olimpiade Komputer Indonesia).</p>
  <p>Bidang <b>informatika</b> (dahulu komputer) merupakan salah satu bidang yang dilombakan, yang menguji penyelesaian masalah (<i>problem solving</i>) melalui soal-soal pemrograman <i>(<strong>competitive programming</strong>)</i>.</p>
  <p>Untuk dapat bertanding di OSN tingkat nasional, siswa harus ditunjuk melalui pihak sekolah untuk mengikuti OSN tingkat kota/kabupaten (<b>OSN-K</b>) terlebih dahulu. Kemudian, para siswa terbaik tingkat kota akan ditandingkan di tingkat provinsi (<b>OSN-P</b>) dan kemudian nasional (<b>OSN</b>).</p> 
  <p>Para medalis akan diseleksi lebih lanjut untuk memilih 4 siswa yang akan mewakili Indonesia pada ajang <a href="https://ioinformatics.org/"><strong>International Olympiad in Informatics</strong></a> (<strong>IOI</strong>).</p>
</div>
<div class="bp3-card">
  <p>(Sebelum tahun 2020, rangkaian olimpiade ini disebut <b>OSK</b>, <b>OSP</b>, dan <b>OSN</b>. Khusus tahun 2020 - 2021, rangkaian olimpiade ini disebut <b>KSN-K</b>, <b>KSN-P</b>, dan <b>KSN</b>. )</p>
</div>
<hr />
<table>
  <tr>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/persiapan'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-form"></span>&nbsp;&nbsp;Persiapan</h3>
        <p>Persiapkan diri Anda dalam menghadapi OSN Bidang Informatika.</p>
      </div>
    </td>
    <td class="section-cell">
      <div class="bp3-card bp3-interactive home-card" onclick="location.href='/silabus'">
        <h3 class="bp3-heading"><span class="bp3-icon-large bp3-icon-properties"></span>&nbsp;&nbsp;Silabus</h3>
        <p>Ketahui materi apa saja yang akan diujikan pada OSN Bidang Informatika.</p>
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
