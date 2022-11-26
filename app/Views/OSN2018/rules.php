<div class="bp3-card">
	<h3 id="a-teknis-umum">A. Teknis Umum</h3>
	<ol>
		<li>OSN Informatika 2018 terdiri atas <strong>1 hari uji coba</strong> dan <strong>2 hari kompetisi</strong>.</li>
		<li>Hasil pada hari uji coba <strong>tidak</strong> termasuk dalam penilaian.</li>
		<li>Pada setiap hari kompetisi, terdapat <strong>3 buah soal</strong> yang diujikan selama <strong>5 jam</strong>.</li>
		<li>Setiap peserta mendapatkan jatah sebanyak <strong>50 kali pengumpulan</strong> untuk setiap soal.</li>
		<li>Bahasa pemrograman yang diperbolehkan adalah <strong>C</strong>, <strong>C++</strong>, dan <strong>Pascal</strong>.</li>
		<li>Selama kompetisi, peserta hanya dapat melihat nilai diri sendiri.</li>
	</ol>

	<hr />

	<h3 id="b-tipe-soal">B. Tipe Soal</h3>

	<ol>
		<li>Terdapat <strong>3 tipe soal</strong> yang mungkin diujikan: <strong>batch</strong>, <strong>interactive</strong>, dan <strong>output-only</strong>. Mungkin saja terdapat tipe soal yang tidak diujikan.</li>
		<li>Pada soal bertipe <em>batch</em>:
			<ol>
				<li>Peserta membuat sebuah program yang membaca masukan kasus uji dari <strong>stdin</strong> dan mencetak jawaban ke <strong>stdout</strong>.</li>
				<li>Program harus mengeluarkan jawaban dalam batas waktu dan memori yang dinyatakan pada soal.</li>
				<li>Contoh soal: <a href="https://training.ia-toki.org/problemsets/91/problems/469/">Pertahanan Pekanbaru, OSN 2017</a>.</li>
			</ol>
		</li>
		<li>Pada soal bertipe <em>interactive</em>:
			<ol>
				<li>Peserta membuat sebuah program yang berinteraksi dengan program juri: program juri memberikan keluaran ke <strong>stdout</strong>, yang menjadi masukan <strong>stdin</strong> untuk program peserta, kemudian program peserta memberikan keluaran ke <strong>stdout</strong>, dan seterusnya, untuk mencapai tujuan tertentu yang dinyatakan pada soal.</li>
				<li>Program harus mengeluarkan jawaban dalam batas waktu dan memori yang dinyatakan pada soal.</li>
				<li>Contoh soal: <a href="https://training.ia-toki.org/problemsets/91/problems/471/">Daratan dan Es, OSN 2017</a>.</li>
			</ol>
		</li>
		<li>Pada soal bertipe <em>output-only</em>:
			<ol>
				<li>Peserta diberikan seluruh masukan dari kasus-kasus uji soal.</li>
				<li>Peserta menjawab dengan mengirimkan beberapa <strong>berkas keluaran</strong> yang sudah dikompres.</li>
				<li>Peserta <strong>tidak harus</strong> membuat program untuk menghasilkan berkas-berkas keluaran (boleh dikerjakan secara manual).</li>
				<li>Contoh soal: <a href="https://training.ia-toki.org/problemsets/54/problems/259/">Wisata Palembang, OSN 2016</a>.</li>
			</ol>
		</li>
	</ol>

	<hr />

	<h3 id="c-penilaian-soal">C. Penilaian Soal</h3>

	<ol>
		<li>Terdapat <strong>2 jenis penilaian</strong>: <strong>standar</strong> dan <strong>kreatif</strong>. Soal dengan penilaian kreatif akan dinyatakan secara eksplisit pada soal.</li>
		<li>Pada penilaian standar:
			<ol>
				<li>Untuk soal bertipe <em>batch</em> dan <em>interactive</em>:
					<ol>
						<li>Setiap soal terdiri atas <strong>beberapa subsoal</strong> dengan bobot nilai yang bervariasi.</li>
						<li>Setiap soal terdiri atas <strong>beberapa kasus uji</strong> yang dikelompokkan ke dalam <strong>beberapa test group</strong>.</li>
						<li>Setiap <em>test group</em> termasuk ke dalam satu atau lebih subsoal.</li>
						<li>Untuk mendapatkan nilai pada suatu subsoal, peserta harus menyelesaikan <strong>seluruh test group</strong> yang termasuk pada subsoal yang bersangkutan, <em>kecuali</em> dinyatakan lain pada soal.</li>
						<li>Untuk menyelesaikan sebuah <em>test group</em>, peserta harus menyelesaikan <strong>seluruh kasus uji</strong> pada <em>test group</em> yang bersangkutan.</li>
						<li>Setiap soal mungkin memiliki beberapa <strong>subsoal terbuka</strong> yang mana isi kasus-kasus ujinya diberikan kepada peserta, sehingga memungkinkan dikerjakan secara manual.</li>
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
				<li>Rumus penilaian bervariasi untuk setiap soal, dan akan dinyatakan secara eksplisit pada soal.</li>
				<li>Contoh soal:
					<ul>
						<li><em>Batch</em>: <a href="https://training.ia-toki.org/problemsets/45/problems/224/">Membaca, OSN 2012</a>.</li>
						<li><em>Interactive</em>: <a href="https://training.ia-toki.org/problemsets/39/problems/202/">Cat Rumah, OSN 2014</a>.</li>
						<li><em>Output-only</em>: <a href="https://training.ia-toki.org/problemsets/54/problems/259/">Wisata Palembang, OSN 2016</a>.</li>
					</ul>
				</li>
			</ol>
		</li>
	</ol>

	<hr />

	<h3 id="d-penilaian-peserta">D. Penilaian Peserta</h3>

	<ol>
		<li>Nilai peserta pada suatu soal merupakan <strong>nilai terbesar</strong> dari seluruh pengumpulan peserta pada soal tersebut.</li>
		<li>Total nilai peserta adalah total nilai yang didapatkan pada <strong>seluruh soal</strong> pada <strong>seluruh hari kompetisi</strong>.</li>
		<li>Peserta akan diurutkan peringkat berdasarkan total nilai (semakin besar, semakin bagus).</li>
		<li>Dua peserta yang memiliki total nilai yang <strong>sama</strong> akan mendapat peringkat yang <strong>sama</strong>.</li>
		<li>Waktu pengumpulan <strong>tidak berpengaruh</strong> sama-sekali pada peringkat peserta.</li>
	</ol>

	<hr />

	<h3 id="e-sistem-grading">E. Sistem Grading</h3>

	<ol>
		<li>Sistem <em>grading</em> yang digunakan adalah <a href="https://tlx.toki.id">TLX</a>.</li>
		<li>Besarnya berkas <em>source code</em> yang boleh dikumpulkan untuk setiap soal maksimum <strong>300 KB</strong>.</li>
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
		<li>Peserta dapat mengajukan klarifikasi soal dalam <strong>2 jam pertama</strong> setiap hari kompetisi.</li>
		<li>Setiap klarifikasi hanya akan dijawab dengan salah satu dari balasan berikut:
			<ul>
				<li>Ya</li>
				<li>Tidak</li>
				<li>Baca soal lebih teliti</li>
				<li>Tidak ada komentar</li>
				<li>Baca pengumuman</li>
			</ul>
		</li>
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

	<p><strong>Komputer</strong></p>
	<ul>
		<li>Intel i3-2100 @ 3.10 GHz</li>
		<li>2 GB RAM</li>
	</ul>

	<p><strong>Sistem Operasi</strong></p>
	<ul>
		<li>Ubuntu 16.04</li>
	</ul>

	<p><strong>Browser</strong></p>
	<ul>
		<li>Mozilla Firefox</li>
	</ul>

	<p><strong>Aplikasi</strong></p>
	<ul>
		<li>Gedit</li>
		<li>Geany</li>
		<li>Free Pascal IDE</li>
	</ul>

	<p><strong>Kompilator</strong></p>
	<ul>
		<li>gcc 4.8</li>
		<li>g++ 4.8</li>
		<li>fpc 3.0</li>
	</ul>

	<p><strong>Dokumentasi</strong></p>
	<ul>
		<li><a href="http://sourceforge.net/projects/freepascal/files/Documentation/3.0.4">http://sourceforge.net/projects/freepascal/files/Documentation/3.0.4</a></li>
		<li><a href="http://upload.cppreference.com/mwiki/images/0/0f/html_book_20180311.zip">http://upload.cppreference.com/mwiki/images/0/0f/html_book_20180311.zip</a></li>
	</ul>

	<hr />

	<p>Berikut ini adalah spesifikasi sistem <em>grader</em> juri.</p>

	<ul>
		<li>Intel Xeon E3-1220 v6 @ 3.00 GHz</li>
		<li>32 GB RAM</li>
		<li>Ubuntu 14.04</li>
	</ul>
</div>
