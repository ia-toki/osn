<div class="bp3-callout bp3-intent-warning">
    <p>Perbedaan dengan <a href="/OSN2024/peraturan">Peraturan OSN 2024</a> ditandai dengan <span style="color:red">warna merah</span>.</p>
    <p><strong style="color:red">PENTING:</strong> perhatikan perubahan sistem peringkat pada poin D.5!</p>
</div>

<br />


<div class="bp3-card">
    <h3 id="a-teknis-umum">A. Teknis Umum</h3>

    <ol>
    <li>OSN 2025 Bidang Informatika terdiri atas <strong>1 hari uji coba</strong> dan <strong>2 hari kompetisi</strong>.</li>
    <li>Hasil pada hari uji coba <strong>tidak</strong> termasuk dalam penilaian.</li>
    <li>Pada setiap hari kompetisi, terdapat <strong>3 buah soal</strong> yang diujikan selama <strong>5 jam</strong>.</li>
    <li>Setiap peserta mendapatkan jatah sebanyak <strong>50 kali pengumpulan</strong> untuk setiap soal. Jatah ini bisa saja ditambahkan untuk beberapa soal tertentu.</li>
    <li>Bahasa pemrograman yang diperbolehkan adalah <strong>C++</strong>.</li>
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
        <li>Contoh soal: <a href="https://tlx.toki.id/problems/osn-2023/1A">Pertahanan Bogor, OSN 2023</a>.</li>
        </ol>
    </li>
    <li>Pada soal bertipe <em>interactive</em>:
        <ol>
        <li>Peserta membuat sebuah program yang berinteraksi dengan program juri: program juri memberikan keluaran ke <strong>stdout</strong>, yang menjadi masukan <strong>stdin</strong> untuk program peserta, kemudian program peserta memberikan keluaran ke <strong>stdout</strong>, dan seterusnya, untuk mencapai tujuan tertentu yang dinyatakan pada soal.</li>
        <li>Program harus mengeluarkan jawaban dalam batas waktu dan memori yang dinyatakan pada soal.</li>
        <li>Contoh soal: <a href="https://tlx.toki.id/problems/osn-2023/2C">Pengiriman Satu Hari, OSN 2023</a>.</li>
        </ol>
    </li>
    <li>Pada soal bertipe <em>output-only</em>:
        <ol>
        <li>Peserta diberikan seluruh masukan dari kasus-kasus uji soal.</li>
        <li>Peserta menjawab dengan mengirimkan beberapa <strong>berkas keluaran</strong> yang sudah dikompres.</li>
        <li>Peserta <strong>tidak harus</strong> membuat program untuk menghasilkan berkas-berkas keluaran (boleh dikerjakan secara manual).</li>
        <li>Contoh soal: <a href="https://tlx.toki.id/problems/ksn-2020/1A">Pertahanan Negara, KSN 2020</a>.</li>
        </ol>
    </li>
    </ol>

    <hr />

    <h3 id="c-penilaian-soal">C. Penilaian Soal</h3>

    <ol>
        <li>Untuk soal bertipe <em>batch</em> dan <em>interactive</em>:
            <ol>
            <li>Setiap soal terdiri atas <strong>beberapa subsoal</strong> dengan bobot nilai yang bervariasi.</li>
            <li>Setiap soal terdiri atas <strong>beberapa kasus uji</strong> yang dikelompokkan ke dalam <strong>beberapa subsoal</strong>.</li>
            <li>Untuk mendapatkan nilai pada suatu subsoal, peserta harus menyelesaikan <strong>seluruh kasus uji</strong> yang termasuk pada subsoal yang bersangkutan, <em>kecuali</em> dinyatakan lain pada soal.</li>
            <li>Setiap soal mungkin memiliki beberapa <strong>subsoal terbuka</strong> yang isi kasus-kasus ujinya diberikan kepada peserta, sehingga memungkinkan dikerjakan secara manual.</li>
            </ol>
        </li>
        <li>Untuk soal bertipe <em>output-only</em>:
            <ol>
            <li>Setiap soal terdiri atas <strong>beberapa kasus uji</strong> dengan bobot nilai yang bervariasi.</li>
            <li>Untuk mendapatkan nilai pada suatu kasus uji, peserta harus menyelesaikan kasus uji tersebut.</li>
            </ol>
        </li>
        <li>Untuk setiap soal, penilaian juga bisa diberikan relatif terhadap hasil yang diperoleh solusi juri, atau sesuai dengan rumus yang diberikan.
            <ol>
            <li>Rumus penilaian akan dinyatakan secara eksplisit pada soal.</li>
            <li>Contoh soal:
                <ul>
                <li><em>Batch</em>: <a href="https://tlx.toki.id/problems/osn-2025-semifinal/C">Kebun Apel, Semifinal OSN 2025</a>.</li>
                <li><em>Interactive</em>: <a href="https://tlx.toki.id/problems/osn-2024/0B">Harta Karun Nasional, OSN 2024</a>.</li>
                <li><em>Output-only</em>: <a href="https://tlx.toki.id/problems/osn-2024/0C">Mosaik Monokrom, OSN 2024</a>.</li>
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
    <li><span style="color: red;"><s>Dua peserta yang memiliki total nilai yang sama akan mendapat peringkat yang sama.<br>
    Waktu pengumpulan tidak berpengaruh sama-sekali pada peringkat peserta.<br><br></s></span>
    <div style="color: red;">Peserta-peserta yang memiliki total nilai yang sama akan diurutkan berdasarkan <b>penalti waktu</b>, yakni <b>jumlah</b> waktu (durasi) <b>pertama kali</b> tercapainya <b>nilai terakhir</b> pada <b>setiap harinya</b>.
    Semakin kecil penalti waktu, semakin bagus.
    <br><br>
    Sebagai contoh, misalkan Andi mendapatkan:
    <ul>
        <li>nilai terakhir 200 poin pada Hari 1, yang tercapai dalam waktu 2 jam</li>
        <li>nilai terakhir 150 poin pada Hari 2, yang tercapai dalam waktu 2 jam 10 menit</li>
    </ul>
    <br>
    dan Budi mendapatkan:
    <ul>
        <li>nilai terakhir 170 poin pada Hari 1, yang tercapai dalam waktu 1 jam 10 menit</li>
        <li>nilai terakhir 180 poin pada Hari 2, yang tercapai dalam waktu 2 jam 50 menit</li>
    </ul>
    <br>

    Dalam hal ini, meskipun total nilai mereka sama yakni <b>350</b>, peringkat Budi akan <b>lebih bagus</b> (di atas) Andi, karena penalti waktu Budi lebih kecil (yakni <b>4 jam</b>) dibandingkan Andi (yakni <b>4 jam 10 menit</b>).

    </div>
    </li>
    </ol>

    <hr />

    <h3 id="e-sistem-grading">E. Sistem Grading</h3>

    <ol>
    <li>Sistem <em>grading</em> yang digunakan adalah sistem serupa <a href="https://tlx.toki.id">TLX</a>.</li>
    <li>Besarnya berkas <em>source code</em> yang boleh dikumpulkan untuk setiap soal maksimum <strong>300 KB</strong>.</li>
    <li>Untuk setiap kasus uji, balasan <em>grader</em> yang mungkin adalah:
        <ol>
        <li><strong>Accepted</strong>: program berhasil menyelesaikan kasus uji dalam batas waktu dan memori.</li>
        <li><strong>Wrong Answer</strong>: program berhenti dalam batas waktu dan memori, namun menghasilkan keluaran yang salah.</li>
        <li><strong>Runtime Error</strong>: program <em>crash</em> atau melebihi batas memori.</li>
        <li><strong>Time Limit Exceeded</strong>: program melebihi batas waktu.</li>
        <li><strong>Skipped</strong>: <em>grading</em> tidak dilakukan karena sudah ada kasus uji lain dalam subsoal yang sama yang tidak mendapatkan AC.</li>
        </ol>
    </li>
    </ol>

    <hr />

    <h3 id="f-klarifikasi">F. Klarifikasi</h3>

    <ol>
    <li>Peserta dapat mengajukan klarifikasi selama kompetisi berlangsung.</li>
    <li>Setiap klarifikasi yang berhubungan dengan soal hanya akan dijawab dengan salah satu dari balasan berikut:
        <ul>
        <li>"Ya"</li>
        <li>"Tidak"</li>
        <li><span style="color: red; font-weight: bold;">"Tidak ada komentar / jawaban terdapat pada deskripsi soal"</span> <br />
    Deskripsi soal telah mengandung informasi yang cukup. Peserta diimbau untuk membaca ulang soal dengan lebih teliti.</li>
        <li>"Pertanyaan tidak <i>valid</i>" <br />
    Pertanyaan tidak bisa dijawab dengan jawaban Ya/Tidak. Peserta disarankan untuk mengulangi pertanyaannya.</li>
        <li><span style="color: red"><s>"Tidak ada komentar" <br />
    Peserta menanyakan informasi yang tidak bisa diberikan jawabannya.</s></span></li>
        </ul>
    </li>
    <li>Jawaban dari klarifikasi bisa saja mempunyai informasi tambahan jika sekiranya diperlukan.</li>
    </ol>

    <hr />

    <h3 id="g-lain-lain">G. Lain-Lain</h3>

    <ol>
    <li>Peserta tidak boleh menggunakan barang-barang pribadi ke dalam tempat lomba, <strong>kecuali</strong> maskot kecil dan alat-alat tulis.</li>
    <li>Apabila terjadi hal-hal yang tidak terduga (misalnya: mati listrik, jaringan internet terputus dan lain-lain), maka panitia memiliki <strong>hak diskresi</strong> untuk menambah waktu kompetisi menjadi lebih lama dari 5 jam, sesuai yang diperlukan.</li>
    <li>Peserta yang melakukan kecurangan akan mendapatkan <strong>sanksi</strong> berupa nilai 0 atau bahkan didiskualifikasi. Kecurangan misalnya, namun tidak terbatas, pada:
      <ol>
        <li>Melakukan komunikasi dengan peserta lain atau juri selama kompetisi berlangsung di luar sistem yang telah disediakan.</li>
        <li>Mengakses akun peserta lain.</li>
        <li>Mengakses komputer atau jaringan lain selain yang diperbolehkan.</li>
        <li>Mencoba untuk mengakses <em>root</em> komputer.</li>
        <li>Mencoba untuk merusak sistem <em>grader</em>.</li>
        <li>Mengganggu peserta lain.</li>
      </ol>
    </li>
    </ol>
</div>

<div class="bp3-card">
    <h3>H. Spesifikasi Teknis</h3>
    <p>Berikut ini spesifikasi komputer setiap peserta.</p>

    <p><strong>Sistem Operasi</strong></p>
    <ul>
      <li><span style="color: red; font-weight: bold;">Ubuntu 24.04</span></li>
    </ul>

    <p><strong>Browser</strong></p>
    <ul>
      <li>Google Chrome</li>
    </ul>

    <p><strong>Aplikasi</strong></p>
    <ul>
      <li>Geany</li>
      <li><span style="color: red"><s>Dev-C++</s></span></li>
      <li>Visual Studio Code</li>
    </ul>

    <p><strong>Kompilator</strong></p>
    <ul>
      <li>g++ <span style="color: red; font-weight: bold;">13 (C++20)</span></li>
    </ul>

    <p><strong>Debugger</strong></p>
    <ul>
      <li>gdb</li>
    </ul>

    <p><strong>Dokumentasi</strong></p>
    <ul>
      <li><a href="https://www.cppreference.com/">cppreference.com</a></li>
    </ul>

    <hr />

    <h3 id="spesifikasi-grader">I. Spesifikasi <em>Grader</em></h3>

    <p><b>Mesin</b></p>

    <ul>
    <li>2 GB RAM</li>
    </ul>

    <p><b>Kompilator C++</b></p>

    <ul>
    <li>g++ <span style="color: red; font-weight: bold;">13 (C++20)</span></li>
    </ul>
</div>
