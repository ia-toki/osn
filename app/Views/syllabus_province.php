<?= $this->extend('syllabus') ?>

<?= $this->section('subcontent') ?>

<div class="bp3-callout bp3-intent-warning">
  <p>Perbedaan dengan Silabus OSN-P 2024 ditandai dengan <span style="color:red">warna merah</span>.</p>
</div>
<br/>
<div class="bp3-card">
  <h3>Materi</h3>
  <p>Materi yang diajukan mengacu kepada <a href="/silabus">silabus OSN</a>.
  <hr/>
  <h3>Bentuk Soal</h3>
  <p>Terdapat <span style="color:red"><s>6 bagian</s> <b>5&ndash;8 studi kasus</b></span> yang dikerjakan selama <b>3 jam</b>.</p>
  <p>Setiap <span style="color:red"><s>bagian</s> studi kasus berupa <b>Pemecahan Masalah Komputasional</b> (seperti bagian B OSN-K), yang masing-masing</span> terdiri atas:</p>
  <ul>
    <li>3 soal pemahaman, yang dapat berupa pilihan ganda, isian singkat, atau pertanyaan benar/salah.</li>
    <li>1 soal pemrograman, yang terdiri atas 2 subsoal: mudah dan sulit.</li>
  </ul>
  <hr/>
  <h3>Contoh Soal</h3>
  <div style="max-width: 650px; margin-left: auto; margin-right: auto">
    <h4>A. Berbagi Candil</h4>
    <h5>Deskripsi</h5>
    <p>Pak Dengklek memiliki N ekor bebek. Pagi hari ini, Pak Dengklek telah membeli M butir candil untuk dibagikan ke bebek-bebeknya. Perhatikan bahwa nilai M ini bisa saja 0 yang artinya Pak Dengklek sebenarnya tidak membeli candil.</p>
    <p>Pak Dengklek ingin membagikan candil-candil tersebut <b>sebanyak mungkin</b> kepada bebek-bebeknya selama setiap bebeknya mendapatkan banyak butir candil yang <b>sama rata</b>. Setelah membagikan candil-candil tersebut, sisa candil akan dimakan oleh Pak Dengklek.</p>
    <p>Tugas Anda adalah menentukan banyaknya candil yang akhirnya dimakan oleh Pak Dengklek.</p>

    <h5>Soal A1</h5>
    <p>Jika Pak Dengklek membeli 100 butir candil untuk dibagikan ke 7 ekor bebeknya, berapakah banyaknya candil yang akhirnya dimakan oleh Pak Dengklek?</p>
    <p><b>Tuliskan jawaban dalam bentuk ANGKA.</b></p>

    <h5>Soal A2</h5>
    <p>Asumsikan Pak Dengklek memiliki 10 ekor bebek. Dari 5 skenario berikut, manakah yang menyebabkan Pak Dengklek akhirnya memakan butir candil <b>paling banyak</b>?</p>

    <ul>
      <li>a. Pak Dengklek membeli 8 butir candil</li>
      <li>b. Pak Dengklek membeli 12 butir candil</li>
      <li>c. Pak Dengklek membeli 27 butir candil</li>
      <li>d. Pak Dengklek membeli 64 butir candil</li>
      <li>e. Pak Dengklek membeli 101 butir candil</li>
    </ul>

    <h5>Soal A3</h5>
    <p>BENAR atau SALAH: Banyak candil yang akhirnya dimakan oleh Pak Dengklek selalu lebih kecil dari N.</p>
    
    <p><b>Tuliskan jawaban dalam bentuk BENAR/SALAH dengan huruf kapital.</b></p>

    <h5>Soal Pemrograman</h5>

    <p>Tulislah sebuah program dengan bahasa C/C++ sesuai deskripsi cerita dengan format dan batasan sebagai berikut. Perhatikan bahwa untuk setiap kasus uji berlaku batas waktu selama 2 detik dan batas memori sebanyak 256 MB.</p>

    <p><b>Masukan</b></p>
    <p>Masukan diberikan dalam format berikut:</p>
    <pre>N M</pre>

    <p><b>Keluaran</b></p>
    <p>Keluarkan sebuah baris berisi sebuah bilangan bulat yang menyatakan banyaknya candil yang akhirnya dimakan oleh Pak Dengklek.</p>

    <p><b>Contoh Masukan dan Keluaran</b></p>
    <table border="1" style="margin-bottom: 10px">
      <thead>
        <tr><th>Contoh Masukan</th><th>Contoh Keluaran</th></tr>
      </thead>
      <tbody>
        <tr><td><pre>8 21</pre></td><td><pre>5</pre></td></tr>
        <tr><td><pre>1 999</pre></td><td><pre>0</pre></td></tr>
        <tr><td><pre>15 0</pre></td><td><pre>0</pre></td></tr>
      </tbody>
    </table>

    <p><b>Penjelasan Contoh</b></p>

    <p>Pada contoh pertama, Pak Dengklek paling banyak dapat membagikan 16 butir candil kepada 8 bebeknya sehingga setiap bebek akan mendapatkan 2 butir candil. Sisa candil yang akhirnya dimakan oleh Pak Dengklek adalah 5.</p>
    <p>Pada contoh kedua, karena Pak Dengklek hanya memiliki 1 ekor bebek, maka ia dapat memberikan seluruh candilnya kepada bebek tersebut.</p>
    <p>Pada contoh ketiga, Pak Dengklek tidak membeli candil sehingga ia maupun bebek-bebeknya tidak makan candil.</p>

    <p><b>Subsoal 1 (Mudah)</b></p>
    <p>Hanya berisi satu buah kasus uji, yakni:</p>
    <pre>123 4567890</pre>

    <p><b>Subsoal 2 (Sulit)</b></p>
    <ul>
      <li>1 &le; N &le; 10<sup>12</sup></li>
      <li>0 &le; M &le; 10<sup>12</sup></li>
    </ul>

    <p><b>Peringatan</b></p>
    <p>Untuk dapat menjawab pertanyaan ini dengan benar, Anda mungkin perlu menggunakan tipe data <b>long long</b> untuk dapat menyimpan data dengan nilai yang besar. Tipe data <b>int</b> saja mungkin tidak cukup!</p>

    <hr>
  
    <h4>B. Menghitung Subsekuens OSN</h4>

    <h5>Deskripsi</h5>

    <p>Diberikan sebuah string S dengan panjang N yang hanya terdiri dari huruf-huruf 'O', 'S', dan 'N'; Anda diminta untuk menghitung berapa banyak kemunculan subsekuens "OSN" dari string tersebut.</p>
    <p>Secara persisnya, Anda diminta untuk menghitung banyaknya cara memilih huruf 'O', 'S', dan 'N' dari string yang diberikan sehingga huruf 'O' yang dipilih berada sebelum huruf 'S' yang dipilih, dan huruf 'S' yang dipilih berada sebelum huruf 'N' yang dipilih.</p>

    <h5>Soal B1</h5>
    <p>Manakah dari 5 pilihan string berikut yang memiliki kemunculan subsekuens "OSN" <b>paling banyak</b>?</p>
    <ul>
      <li>a. "OSNOSN"</li>
      <li>b. "OSSNNN"</li>
      <li>c. "OSSSSSN"</li>
      <li>d. "ONNNSOOON"</li>
      <li>e. "NONONONONON"</li>
    </ul>

    <h5>Soal B2</h5>
    <p>Dari seluruh kemungkinan string dengan panjang 9, tuliskan string yang memiliki kemunculan subsekuens "OSN" <b>paling banyak</b>! Jika terdapat lebih dari satu kemungkinan jawaban, pilih yang <b>paling kecil</b> secara leksikografis.</p>
    <p><b>Tuliskan jawaban dalam bentuk STRING dengan huruf kapital.</b></p>

    <h5>Soal B3</h5>
    <p>Pada string "SONOSONOSONOSONOSONOSONOSONO" (yakni penggabungan 7 kali string "SONO"), berapa kalikah subsekuens "OSN" muncul?</p>
    <p><b>Tuliskan jawaban dalam bentuk ANGKA.</b></p>

    <h5>Soal Pemrograman</h5>

    <p>Tulislah sebuah program dengan bahasa C/C++ sesuai deskripsi cerita dengan format dan batasan sebagai berikut. Perhatikan bahwa untuk setiap kasus uji berlaku batas waktu selama 2 detik dan batas memori sebanyak 256 MB.</p>
   
    <p><b>Masukan</b></p>
    <p>Masukan diberikan dalam format berikut:</p>
    <pre>N
S</pre>

    <p><b>Keluaran</b></p>
    <p>Keluarkan sebuah baris berisi sebuah bilangan bulat yang menyatakan banyaknya kemunculan subsekuens "OSN" dari string S.</p>
    
    <p><b>Contoh Masukan dan Keluaran</b></p>
    <table border="1" style="margin-bottom: 10px">
      <thead>
        <tr><th>Contoh Masukan</th><th>Contoh Keluaran</th></tr>
      </thead>
      <tbody>
        <tr><td><pre>8
SONOSONO</pre></td><td><pre>2</pre></td></tr>
      </tbody>
    </table>

    <p><b>Penjelasan Contoh</b></p>

    <p>Ada 2 kemunculan subsekuens "OSN" pada string "SONOSONO", yakni dengan memilih huruf ke-2, 5, dan 7; serta dengan memilih huruf ke-4, 5, dan 7.</p>
  
    <p><b>Batasan</b></p>
    <p>Untuk seluruh kasus uji, berlaku:</p>
    <ul>
      <li>|S| = N</li>
      <li>S hanya terdiri dari huruf-huruf 'O', 'S', dan 'N'.
    </ul>

    <p><b>Subsoal 1 (Mudah)</b></p>
    <ul>
      <li>1 &le; N &le; 200</li>
    </ul>

    <p><b>Subsoal 2 (Sulit)</b></p>
    <ul>
      <li>1 &le; N &le; 200.000</li>
    </ul>

    <p><b>Peringatan</b></p>
    <p>Untuk dapat menjawab pertanyaan ini dengan benar, Anda mungkin perlu menggunakan tipe data <b>long long</b> untuk dapat menyimpan data dengan nilai yang besar. Tipe data <b>int</b> saja mungkin tidak cukup!</p>

  </div>
</div>

<?= $this->endSection() ?>
