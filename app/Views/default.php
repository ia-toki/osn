<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">

	<title>KSN Informatika</title>

	<link rel="shortcut icon" href="/toki-logo.png">
	<link rel="stylesheet" href="/main.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@blueprintjs/core@3.35.0/lib/css/blueprint.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@blueprintjs/icons@3.22.0/lib/css/blueprint-icons.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
</head>

<body>
	<nav class="bp3-navbar bp3-dark header">
		<div class="header__wrapper">
			<div class="bp3-navbar-group bp3-align-left">
				<img src="/toki-logo.png" class="header__logo">
				<div class="bp3-navbar-heading header__title">Kompetisi Sains Nasional Bidang Informatika</div>
				<span class="bp3-navbar-divider" />
				<div class="header__subtitle">Tim Olimpiade Komputer Indonesia (TOKI)</div>
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
					<li class="bp3-tab" role="tab" aria-selected="<?= $menu == 'competition' ? 'true' : 'false' ?>">
            <a href="/kompetisi">Kompetisi</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="content">
		<?= $this->renderSection('content') ?>
	</div>

</body>
</html>
