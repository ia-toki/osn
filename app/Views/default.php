<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">

	<title>OSN Informatika</title>

	<link rel="shortcut icon" href="/osn-logo.png">
	<link rel="stylesheet" href="/main3.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@blueprintjs/core@3.35.0/lib/css/blueprint.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@blueprintjs/icons@3.22.0/lib/css/blueprint-icons.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-182293493-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-182293493-1');
	</script>

</head>

<body>
	<nav class="bp3-navbar bp3-dark header">
		<div class="header__wrapper">
			<div class="bp3-navbar-group bp3-align-left">
				<img src="/osn-logo.png" class="header__logo">
				<div class="bp3-navbar-heading header__title">Olimpiade Sains Nasional Bidang Informatika</div>
				<span class="bp3-navbar-divider" />
				<div class="header-right header__subtitle"><img src="/id-flag.png" class="header__flag"> Indonesian National Olympiad in Informatics</div>
			</div>
			<div class="bp3-navbar-group bp3-align-right">
				<img src="/toki-logo.png" class="header__logo">
				<img src="/tut-wuri-logo.png" class="header__logo">
			</div>
		</div>
  </nav>
  
  <div class="menubar">
    <div class="menubar__content">
      <div class="bp3-tabs">
        <ul class="bp3-tab-list" role="tablist">
          <li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'home' ? 'true' : 'false' ?>">
            <a href="/">Beranda</a>
					</li>
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'preparation' ? 'true' : 'false' ?>">
            <a href="/persiapan">Persiapan</a>
					</li>
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'syllabus' ? 'true' : 'false' ?>">
            <a href="/silabus">Silabus</a>
					</li>
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'competition' ? 'true' : 'false' ?>">
            <a href="/olimpiade">Olimpiade</a>
          </li>
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'archive' ? 'true' : 'false' ?>">
            <a href="/arsip">Arsip Soal</a>
          </li>
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'statistics' ? 'true' : 'false' ?>">
            <a href="/statistik">Statistik</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="content">
		<?= $this->renderSection('content') ?>

		<hr />
		<div class="bp3-callout home-footer">
			<p><small><i>Situs ini dikelola oleh <a href="https://alumni.toki.id"><b>Ikatan Alumni Tim Olimpiade Komputer Indonesia</b></a> (IA TOKI).</small></i>
			<i><small>Ingin memperbaiki informasi/data? Laporkan pada <a href="http://github.com/ia-toki/osn-web"><b>github.com/ia-toki/osn-web</b></a></small></i>.</p>
		</div>
	</div>
</body>
</html>
