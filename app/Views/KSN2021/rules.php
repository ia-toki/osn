
<p>Perbedaan dengan <a href="/KSN2020/peraturan">Peraturan KSN Informatika 2020</a> ditandai <span style="color:red">warna merah</span>.</p>

<hr />

<h3 id="a-teknis-umum">A. Teknis Umum</h3>

<ol>
  <li>KSN 2021 Bidang Informatika terdiri atas <strong>1 hari uji coba</strong> dan <strong>2 hari kompetisi</strong>.</li>
  <li>Hasil pada hari uji coba <strong>tidak</strong> termasuk dalam penilaian.</li>
  <li>Pada setiap hari kompetisi, terdapat <strong>3 buah soal</strong> yang diujikan selama <strong>5 jam</strong>.</li>
  <li>Setiap peserta mendapatkan jatah sebanyak <strong>50 kali pengumpulan</strong> untuk setiap soal.
  <span style="color:red">Jatah ini bisa saja ditambahkan untuk beberapa soal tertentu</span>.</li>
  <li>Bahasa pemrograman yang diperbolehkan adalah <span style="color:red"><strong>C</strong> dan <strong>C++</strong></span>.</li>
  <li>Selama kompetisi, peserta hanya dapat melihat nilainya sendiri.</li>
</ol>

<hr />

<h3 id="b-tipe-soal">B. Tipe Soal</h3>

<ol>
  <li>
    <p>Terdapat <strong>3 tipe soal</strong> yang mungkin diujikan: <strong>batch</strong>, <strong>interactive</strong>, dan <strong>output-only</strong>. Mungkin saja terdapat tipe soal yang tidak diujikan.</p>
  </li>
  <li>Pada soal bertipe <em>batch</em>:
    <ol>
      <li>Peserta membuat sebuah program yang membaca masukan kasus uji dari <strong>stdin</strong> dan mencetak jawaban ke <strong>stdout</strong>.</li>
      <li>Program harus mengeluarkan jawaban dalam batas waktu dan memori yang dinyatakan pada soal.</li>
      <li>Contoh soal: <a href="https://tlx.toki.id/problems/osn-2018/1C">Ojek Daring, OSN 2018</a>.</li>
    </ol>
  </li>
  <li>Pada soal bertipe <em>interactive</em>:
    <ol>
      <li>Peserta membuat sebuah program yang berinteraksi dengan program juri: program juri memberikan keluaran ke <strong>stdout</strong>, yang menjadi masukan <strong>stdin</strong> untuk program peserta, kemudian program peserta memberikan keluaran ke <strong>stdout</strong>, dan seterusnya, untuk mencapai tujuan tertentu yang dinyatakan pada soal.</li>
      <li>Program harus mengeluarkan jawaban dalam batas waktu dan memori yang dinyatakan pada soal.</li>
      <li>Contoh soal: <a href="https://tlx.toki.id/problems/osn-2019/2B">Mencari Emas, OSN 2019</a>.</li>
    </ol>
  </li>
  <li>Pada soal bertipe <em>output-only</em>:
    <ol>
      <li>Peserta diberikan seluruh masukan dari kasus-kasus uji soal.</li>
      <li>Peserta menjawab dengan mengirimkan beberapa <strong>berkas keluaran</strong> yang sudah dikompres.</li>
      <li>Peserta <strong>tidak harus</strong> membuat program untuk menghasilkan berkas-berkas keluaran (boleh dikerjakan secara manual).</li>
      <li>Contoh soal: <a href="https://tlx.toki.id/problems/osn-2019/1C">Rekreasi OSN, OSN 2019</a>.</li>
    </ol>
  </li>
</ol>

<hr />

<h3 id="c-penilaian-soal">C. Penilaian Soal</h3>

<ol>
  <li>
    <p>Terdapat <strong>2 jenis penilaian</strong>: <strong>standar</strong> dan <strong>kreatif</strong>. Soal dengan penilaian kreatif akan dinyatakan secara eksplisit pada soal.</p>
  </li>
  <li>Pada penilaian standar:
    <ol>
      <li>Untuk soal bertipe <em>batch</em> dan <em>interactive</em>:
        <ol>
          <li>Setiap soal terdiri atas <strong>beberapa subsoal</strong> dengan bobot nilai yang bervariasi.</li>
          <li>Setiap soal terdiri atas <strong>beberapa kasus uji</strong> yang dikelompokkan ke dalam <strong>beberapa test group</strong>.</li>
          <li>Setiap <em>test group</em> termasuk ke dalam satu atau lebih subsoal.</li>
          <li>Untuk mendapatkan nilai pada suatu subsoal, peserta harus menyelesaikan <strong>seluruh test group</strong> yang termasuk pada subsoal yang bersangkutan, <em>kecuali</em> dinyatakan lain pada soal.</li>
          <li>Untuk menyelesaikan sebuah <em>test group</em>, peserta harus menyelesaikan <strong>seluruh kasus uji</strong> pada <em>test group</em> yang bersangkutan.</li>
          <li>Setiap soal mungkin memiliki beberapa <strong>subsoal terbuka</strong> yang isi kasus-kasus ujinya diberikan kepada peserta, sehingga memungkinkan dikerjakan secara manual.</li>
        </ol>
      </li>
      <li>Untuk soal bertipe <em>output-only</em>:
        <ol>
          <li>Setiap soal terdiri atas <strong>beberapa kasus uji</strong> dengan bobot nilai yang bervariasi.</li>
          <li>Untuk mendapatkan nilai pada suatu kasus uji, peserta harus menyelesaikan kasus uji tersebut.</li>
        </ol>
      </li>
    </ol>
  </li>
  <li>Pada penilaian kreatif:
    <ol>
      <li>Penilaian akan diberikan relatif terhadap hasil yang diperoleh solusi juri.</li>
      <li>
        <p>Rumus penilaian bervariasi untuk setiap soal, dan akan dinyatakan secara eksplisit pada soal.</p>
      </li>
      <li>Contoh soal:
        <ul>
          <li><em>Batch</em>: <a href="https://tlx.toki.id/problems/osn-2012/2D">Membaca, OSN 2012</a>.</li>
          <li><em>Interactive</em>: <a href="https://tlx.toki.id/problems/ksn-2020/2C">Mencari Bola, KSN 2020</a>.</li>
          <li><em>Output-only</em>: <a href="https://tlx.toki.id/problems/ksn-2020/1A">Pertahanan Negara, KSN 2020</a>.</li>
        </ul>
      </li>
    </ol>
  </li>
</ol>

<hr />

<h3 id="d-penilaian-peserta">D. Penilaian Peserta</h3>

<ol>
  <li>Pada soal bertipe <em>batch</em> dan <em>interactive</em>:
    <ol>
      <li>Pada penilaian kreatif, untuk setiap pengumpulan, nilai pada suatu subsoal adalah nilai minimum di antara seluruh kasus uji yang dicakup pada subsoal tersebut.</li>
      <li>Nilai akhir pada suatu subsoal adalah <strong>nilai maksimum</strong> subsoal tersebut di antara seluruh pengumpulan.</li>
      <li>Nilai peserta pada suatu soal merupakan jumlah nilai akhir seluruh subsoalnya.</li>
    </ol>

    <p>Sebagai contoh, jika pengumpulan pertama mendapatkan nilai 30 pada subsoal pertama dan nilai 0 pada subsoal kedua, dan pengumpulan kedua mendapatkan nilai 0 pada subsoal pertama dan nilai 40 pada subsoal kedua, maka nilai peserta pada soal ini adalah 70.</p>
  </li>
  <li>Pada soal bertipe <em>output-only</em>:
    <ol>
      <li>Nilai akhir pada suatu kasus uji adalah <strong>nilai maksimum</strong> kasus uji tersebut di antara seluruh pengumpulan.</li>
      <li>Nilai peserta pada suatu soal merupakan jumlah nilai akhir seluruh kasus ujinya.</li>
    </ol>
  </li>
  <li>Total nilai peserta adalah total nilai yang didapatkan pada <strong>seluruh soal</strong> pada <strong>seluruh hari kompetisi</strong>.</li>
  <li>Peserta akan diurutkan peringkat berdasarkan total nilai (semakin besar, semakin bagus).</li>
  <li>Dua peserta yang memiliki total nilai yang <strong>sama</strong> akan mendapat peringkat yang <strong>sama</strong>.</li>
  <li>Waktu pengumpulan <strong>tidak berpengaruh</strong> sama-sekali pada peringkat peserta.</li>
</ol>

<hr />

<h3 id="e-sistem-grading">E. Sistem Grading</h3>

<ol>
  <li>Sistem <em>grading</em> yang digunakan adalah <a href="https://tlx.toki.id">TLX</a>.</li>
  <li>
    <p>Besarnya berkas <em>source code</em> yang boleh dikumpulkan untuk setiap soal maksimum <strong>300 KB</strong>.</p>
  </li>
  <li>Untuk setiap kasus uji, balasan <em>grader</em> yang mungkin adalah:
    <ol>
      <li><strong>AC</strong> (Accepted): program berhasil menyelesaikan kasus uji dalam batas waktu dan memori.</li>
      <li><strong>WA</strong> (Wrong Answer): program berhenti dalam batas waktu dan memori, namun menghasilkan keluaran yang salah.</li>
      <li><strong>RTE</strong> (Runtime Error): program <em>crash</em> atas melebihi batas memori.</li>
      <li><strong>TLE</strong> (Time Limit Exceeded): program melebihi batas waktu.</li>
      <li>Skipped: <em>grading</em> tidak dilakukan karena sudah ada kasus uji lain dalam <em>test group</em> yang sama yang tidak mendapatkan AC.</li>
    </ol>
  </li>
</ol>

<hr />

<h3 id="f-klarifikasi">F. Klarifikasi</h3>

<ol>
  <li>Peserta dapat mengajukan klarifikasi selama kompetisi berlangsung.</li>
  <li>Setiap klarifikasi yang berhubungan dengan soal hanya akan dijawab dengan salah satu dari balasan berikut:
    <ul>
      <li>“Ya”</li>
      <li>“Tidak”</li>
      <li>“Jawaban terdapat pada deskripsi soal” <br />
Deskripsi soal telah mengandung informasi yang cukup. Peserta diimbau untuk membaca ulang soal dengan lebih teliti.</li>
      <li>“Pertanyaan tidak valid” <br />
Pertanyaan tidak bisa dijawab dengan jawaban Ya/Tidak. Peserta disarankan untuk mengulangi pertanyaannya.</li>
      <li>“Tidak ada komentar” <br />
Peserta menanyakan informasi yang tidak bisa diberikan jawabannya.</li>
    </ul>
  </li>
  <li>Jawaban dari klarifikasi bisa saja mempunyai informasi tambahan jika sekiranya diperlukan.</li>
</ol>

<hr />

<h3 id="g-pelaksanaan-kompetisi">G. Pelaksanaan Kompetisi</h3>

<ol>
  <li>Peserta diharuskan untuk mengunggah <strong>pakta integritas</strong> sebelum kompetisi dimulai.</li>
  <li>Peserta diperbolehkan menggunakan <strong>komputer/laptop apa pun</strong>.
    <ul>
      <li>Panitia menyarankan <strong>laptop</strong>, agar ketika terjadi permasalahan listrik, laptop masih bisa dibantu oleh baterai.</li>
    </ul>
  </li>
  <li>Peserta hanya diperbolehkan menggunakan <strong>satu perangkat</strong> komputer/laptop pada <strong>satu waktu</strong>.</li>
  <li>Peserta diperbolehkan menyediakan perangkat <strong>komputer cadangan</strong>, yang hanya boleh digunakan apabila komputer utama mengalami masalah.</li>
  <li>Sistem kompetisi hanya memperbolehkan peserta untuk <strong>login satu kali selama kontes</strong>. Jika peserta perlu login lagi (misalnya jika berganti ke komputer cadangan), peserta harus menghubungi panitia terlebih dahulu melalui narahubung kompetisi.</li>
</ol>

<hr />

<h3 id="h-pengerjaan-soal">H. Pengerjaan Soal</h3>

<ol>
  <li>Peserta diharuskan mengerjakan soal <strong>sendiri tanpa bantuan orang lain</strong>.</li>
  <li>Peserta tidak diperbolehkan berkomunikasi dengan siapa pun, kecuali menghubungi narahubung kompetisi, atau menghubungi juri melalui klarifikasi pada sistem kompetisi.</li>
  <li>Peserta tidak diperbolehkan mengakses situs apa pun, kecuali <strong>sistem kompetisi lomba</strong> dan <strong>dokumentasi bahasa</strong>, yang tautannya akan diberikan pada pengumuman kontes.</li>
  <li>Peserta tidak diperbolehkan <strong>mengakses materi fisik maupun digital apa pun</strong>, seperti <em>template</em> kode, <em>cheatsheet</em>, materi pemrograman dalam bentuk buku/PDF, dan lain-lain.</li>
  <li>Seluruh kode yang di-submit peserta, harus merupakan kode yang <strong>ditulis sendiri oleh peserta selama kompetisi berjalan</strong>. Tidak diperbolehkan melakukan <em>copy-paste</em> kode yang pernah ditulis sebelum kontes.</li>
  <li>Selain <em>web browser</em>, peserta diperbolehkan menggunakan <strong>perangkat lunak apapun yang tidak terhubung pada internet</strong>, selama tidak melanggar aturan lainnya. Misalnya: <em>text editor</em>, <em>compiler</em>, aplikasi kalkulator, <em>spreadsheet</em>, <em>Minesweeper</em>, <em>Paint</em>.</li>
  <li>Peserta diperbolehkan menggunakan <strong>alat tulis</strong> dan <strong>kertas corat-coret apa pun</strong> untuk mengerjakan soal.</li>
  <li>Klarifikasi terkait soal hanya boleh ditanyakan kepada juri dan harus melalui sistem kompetisi.</li>
  <li>Peserta <strong>tidak diperbolehkan menyebarluaskan atau mendiskusikan soal dan solusinya</strong>, selama kompetisi berlangsung, sampai 16 jam sesudah kontes berakhir setiap harinya.</li>
</ol>

<hr />

<h3 id="i-pengawasan-kompetisi">I. Pengawasan Kompetisi</h3>

<ol>
  <li>Kompetisi akan <strong>diawasi secara langsung</strong> oleh tim juri melalui aplikasi <strong>Zoom</strong>.</li>
  <li>Pengawasan ini juga akan direkam oleh tim juri, dan akan menjadi salah satu (bukan satu-satunya) <strong>alat bukti</strong> bagi tim juri untuk memastikan peserta bekerja sesuai prosedur/tata cara kompetisi yang telah ditetapkan.</li>
  <li>Selain perangkat kerja yang digunakan untuk menjawab soal (komputer/laptop), setiap peserta wajib menyediakan <strong>perangkat untuk melakukan pertemuan virtual Zoom</strong> (bisa berupa HP <em>smartphone</em>, laptop, atau PC yang memiliki kamera) dan sudah terinstall aplikasi Zoom di dalamnya.</li>
  <li>Perangkat yang digunakan harus memiliki sambungan internet dan daya (listrik/baterai) yang cukup untuk melakukan pertemuan daring selama kompetisi, dan 15 menit sebelum dan sesudahnya.</li>
  <li>Peserta diharuskan sudah terhubung dengan Zoom 15 menit sebelum kompetisi dimulai.</li>
  <li>Peserta diharuskan mengubah <em>screen/display name</em> dengan format: <code class="language-plaintext highlighter-rouge">Username – Nama</code> (contoh : <code class="language-plaintext highlighter-rouge">010406034 – Deri</code>).</li>
  <li>Peserta tidak diperbolehkan menggunakan <em>virtual background</em>.</li>
  <li>Peserta diharuskan menyalakan mode <strong>video dan audio</strong>.</li>
  <li>Perangkat berkamera yang tersambung wajib diletakkan berjarak 1 - 1,2 meter, pada posisi yang memungkinkan untuk:
    <ul>
      <li>Memantau lingkungan tempat peserta lomba KSN berada</li>
      <li>Memantau aktivitas layar komputer yang digunakan oleh peserta</li>
      <li>Menampakkan wajah dan badan peserta</li>
    </ul>
  </li>
  <li>Peserta diharuskan meletakkan <strong>jam dinding atau jam meja</strong> yang memperlihatkan waktu berjalan pada posisi yang dapat tertangkap kamera Zoom.</li>
  <li>Peserta tidak diperbolehkan menggunakan <strong>alat komunikasi apa pun</strong>, seperti HP (kecuali untuk pengawasan Zoom).</li>
  <li>Peserta tidak diperbolehkan menggunakan <strong>perangkat yang terhubung pada telinga</strong>, seperti headset.</li>
  <li>Peserta dibebaskan untuk <strong>makan/minum</strong> selama kompetisi.</li>
  <li>Selama kompetisi, peserta diperbolehkan meninggalkan ruangan untuk <strong>ke kamar kecil/menjalankan ibadah</strong>. Komputer peserta harus tetap terlihat pada Zoom selama peserta meninggalkan ruangan. Peserta dihimbau untuk tidak berlama-lama meninggalkan ruangan. Selain itu, peserta harus tetap berada di depan komputer/laptop selama kompetisi berlangsung.</li>
</ol>

<hr />

<h3 id="j-permasalahan-teknis">J. Permasalahan Teknis</h3>

<ol>
  <li>Peserta diharapkan menyediakan perlengkapan masing-masing dengan baik, termasuk komputer, alat tulis, dan koneksi internet yang stabil.</li>
  <li>Apabila terdapat gangguan teknis apa pun, peserta diharuskan untuk segera menghubungi narahubung kompetisi.</li>
  <li>Apabila terdapat gangguan teknis apa pun yang tidak bersumber dari pihak panitia, misalnya mati listrik, komputer mati atau koneksi internet putus, <strong>peserta diharuskan untuk menyelesaikan masalah tersebut sendiri dan tidak akan diberikan waktu tambahan</strong>.</li>
  <li>Panitia akan berusaha mengontak peserta/kontak darurat peserta yang terindikasi mengalami gangguan teknis (misalnya, tiba-tiba putus hubungan dari Zoom).</li>
</ol>

<hr />

<h3 id="k-kejujuran-peserta">K. Kejujuran Peserta</h3>

<ol>
  <li>Demi kebaikan bersama, peserta diharapkan <strong>mematuhi seluruh peraturan dengan jujur</strong>.</li>
  <li>Mengingat keterbatasan pengawasan secara daring, jika diperlukan dewan juri, <strong>akan dilakukan wawancara apabila terdapat tanda-tanda kecurangan</strong>.</li>
  <li>Peserta yang terbukti berlaku curang akan <strong>didiskualifikasi</strong>.</li>
</ol>
