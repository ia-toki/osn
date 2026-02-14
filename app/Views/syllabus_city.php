<?= $this->extend('syllabus') ?>

<?= $this->section('subcontent') ?>

<div class="bp3-callout bp3-intent-primary">
  <p>Tidak terdapat perbedaan dengan Silabus OSN-K 2025.</p>
</div>
<br/>
<div class="bp3-card">
  <h3>Pedoman</h3>
  <p>Pedoman pelaksanaan OSN 2026 dapat dilihat <a href="https://pusatprestasinasional.kemendikdasmen.go.id/pengumuman/sd/panduan-osn-tahun-2026-2026-sd">di sini.</a></p>
  <hr>
  <h3>Materi</h3>
  <p>Materi yang diajukan mengacu kepada <a href="/silabus">silabus OSN</a>, yang terdiri atas, namun tidak terbatas pada:</p>
  <ul>
    <li>aljabar Boolean, teori himpunan</li>
    <li>graf, geometri</li>
    <li>kombinatorika, model matematis, deret aritmetika</li>
    <li>simulasi, optimisasi, induksi/deduksi logika, berpikir komputasional (<i>computational thinking</i>)</li>
    <li>masukan/keluaran, membaca algoritma, percabangan, perulangan, <i>array</i>, subprogram, rekursi</li>
  </ul>
  <hr/>
  <h3>Bentuk Soal</h3>
  <p>Terdapat <b>30&ndash;50 soal</b> untuk dikerjakan selama <b>2,5 jam</b>, yang terbagi atas 3 bagian, yakni:</p>
  <h4>A. Abstraksi Berpikir Komputasional</h4>
  <ul>
    <li>Berupa soal cerita bergambar yang secara tak langsung terkait pada aspek dan konsep tertentu dalam informatika dan berpikir komputasional.</li>
    <li>Tipe soal ini mirip dengan soal-soal <a href="https://bebras.or.id/">Bebras</a>.</li>
  </ul>
  <br>
  <h4>B. Pemecahan Masalah Komputasional</h4>
  <ul>
    <li>Berupa studi kasus yang sudah mengarah ke pemecahan masalah dalam pemrograman kompetitif.</li>
    <li>Untuk setiap 1 deskripsi studi kasus, akan ada 3 soal pemahaman yang harus dikerjakan oleh peserta.</li>
    <li>Formatnya mirip dengan format OSN-P 2025 (atau bahkan tingkat nasional OSN). Bedanya, peserta <b>tidak diminta dan tidak perlu membuat program solusi</b>.</li>
    <li>Setiap soal akan dapat diselesaikan dengan cara "dihitung di atas kertas".</li>
  </ul>
  <br>
  <h4>C. Pemahaman Algoritma dalam Bahasa C++</h4>
  <ul>
    <li>Diberikan beberapa kode program (dalam bahasa C++).</li>
    <li>Untuk setiap 1 kode program, akan ada 3 soal yang harus dikerjakan oleh peserta.</li>
    <li>Seperti bagian sebelumnya, setiap soal akan dapat diselesaikan dengan cara "dihitung di atas kertas".</li>
  </ul>
  </li>
  <p>Tidak ada bentukan/tipe khusus untuk masing-masing soal.</p>
  <p>Setiap soal bisa saja berupa pilihan ganda, isian singkat, atau benar/salah. <b>Tidak ada soal esai pada OSN-K</b>.</p>
  <hr/>
  <h3>Contoh Soal</h3>
  <div style="max-width: 650px; margin-left: auto; margin-right: auto">
    <h4>A. Abstraksi Berpikir Komputasional</h4>
    <h5>1. Mesin Penerjemah Bentuk</h5>
    <p>Pak Dengklek memiliki sebuah mesin ajaib yang dapat menerjemahkan 26 huruf alfabet (dari A hingga Z) ke 26 bentuk berbeda. Huruf yang sama akan diterjemahkan ke bentuk yang sama, sedangkan huruf yang berbeda akan diterjemahkan ke bentuk yang berbeda.</p>
    <p>Untuk menggunakan mesin ini, Pak Dengklek terlebih dahulu menuliskan kata yang ingin diterjemahkan. Kemudian, mesin akan mencetak bentuk-bentuk hasil terjemahan setiap huruf di kata tersebut. Pada akhirnya, bentuk-bentuk ini akan dikumpulkan di dalam sebuah wadah yang dilabeli kata yang diterjemahkan.</p>
    <p>Berikut ini merupakan isi dari wadah hasil terjemahan kata "BEBEK" dan "BADAK".</p>
    <img src="/images/osnk-a-1.png" style="display: block; width: 336px; margin-left: auto; margin-right: auto;"/>
    <p>Jika Pak Dengklek ingin menerjemahkan kata "KERA", manakah dari 5 pilihan berikut yang mungkin merupakan isi dari wadah hasil terjemahan?</p>
    <img src="/images/osnk-a-2.png" style="display: block; width: 611px; margin-left: auto; margin-right: auto;"/>
    <br>
    <h5>2. Mengumpulkan Bola dalam Labirin</h5>
    <p>Pak Dengklek memiliki sebuah labirin yang terdiri dari 100 petak, yang tersusun atas 5 baris dan 20 kolom. Terdapat beberapa bola yang tersebar di beberapa petak. Berikut ini merupakan labirin milik Pak Dengklek tersebut.</p>
    <img src="/images/osnk-a-3.png" style="display: block; width: 588px; margin-left: auto; margin-right: auto;"/>
    <br>
    <p>Pak Dengklek ingin meletakkan bebeknya ke salah satu petak kosong. Kemudian, Pak Dengklek ingin bebeknya dapat mengumpulkan sebanyak mungkin bola yang dapat ia temukan. Perhatikan bahwa bebek Pak Dengklek tidak dapat menembus tembok.</p>
    <p>Jika Pak Dengklek meletakkan bebeknya secara optimal, berapa <b>maksimal</b> banyak bola yang dapat dikumpulkan oleh bebeknya?</p>
    <br>
    <h4>B. Pemecahan Masalah Komputasional</h4>
    <h5>3&ndash;5. Menghitung Subsekuens OSN</h5>
    <p>Diberikan sebuah string yang hanya terdiri dari huruf-huruf 'O', 'S', dan 'N'; Anda diminta untuk menghitung berapa banyak kemunculan subsekuens "OSN" dari string tersebut.</p>
    <p>Secara persisnya, Anda diminta untuk menghitung banyaknya cara memilih huruf 'O', 'S', dan 'N' dari string yang diberikan sehingga huruf 'O' yang dipilih berada sebelum huruf 'S' yang dipilih, dan huruf 'S' yang dipilih berada sebelum huruf 'N' yang dipilih.</p>
    <p>Sebagai contoh, ada 2 kemunculan subsekuens "OSN" pada string "SONOSONO", yakni dengan memilih huruf ke-2, 5, dan 7; serta dengan memilih huruf ke-4, 5, dan 7.</p>
    <p><b>Soal 3</b>. Manakah dari 5 pilihan string berikut yang memiliki kemunculan subsekuens "OSN" <b>paling banyak</b>?</p>
    <ul>
      <li>a. "OSNOSN"</li>
      <li>b. "OSSNNN"</li>
      <li>c. "OSSSSSN"</li>
      <li>d. "ONNNSOOON"</li>
      <li>e. "NONONONONON"</li>
    </ul>
    <p><b>Soal 4</b>. Dari seluruh kemungkinan string dengan panjang 9, tuliskan salah satu yang memiliki kemunculan subsekuens "OSN" <b>paling banyak</b>!</p>
    <p><b>Soal 5</b>. Pada string "SONOSONOSONOSONOSONOSONOSONO" (yakni penggabungan 7 kali string "SONO"), berapa kalikah subsekuens "OSN" muncul?</p>
    <br>
    <h4>C. Pemahaman Algoritma dalam Bahasa C++</h4>
    <h5>6&ndash;8. Merah, Kuning, Hijau</h5>
    <p>Perhatikan fungsi-fungsi berikut!</p>
    <img src="/images/osnk-c-1.png" style="display: block; width: 640px; margin-left: auto; margin-right: auto;"/>
    <p><b>Soal 6</b>. Berapakah keluaran dari hijau(123, 456789, 10)?</p>
    <p><b>Soal 7</b>. Asumsikan x, y, dan z adalah bilangan bulat <b>positif</b> tidak lebih dari 100.</p>
    <p>Manakah pernyataan yang <b>salah</b>?</b>
    <ul>
      <li>a. Kompleksitas waktu dari fungsi merah(x, y, z) adalah O(y).</li>
      <li>b. Jika y = z, maka fungsi kuning(x, y, z) dijamin selalu mengeluarkan 0.</li>
      <li>c. Ada x dan y sedemikian sehingga merah(x, y, z) = kuning(x, y, z) untuk z apapun.</li>
      <li>d. Keluaran fungsi hijau(x, y, z) selalu dijamin kurang dari z.</li>
      <li>e. Fungsi hijau(x, y, z) dijamin dapat dijalankan dalam 1 detik pada komputer modern.</li>
    </ul>
    <p><b>Soal 8</b>. Asumsikan x, y, dan z adalah bilangan bulat <b>positif</b> tidak lebih dari 100.</p>
    <p>Jika baris ke-2 diganti dari <code>int hasil = x % z;</code> menjadi hanya <code>int hasil = x;</code> saja, apakah fungsi hijau(x, y, z) selalu berjalan sebagaimana mestinya sebelum diganti?</p>
    <p>Jawablah dengan "YA" atau "TIDAK".</p>
  </div>
</div>

<?= $this->endSection() ?>
