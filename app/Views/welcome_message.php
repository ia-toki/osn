<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">

	<title>KSN 2020 Bidang Informatika</title>

	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="main.css">
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
				<img src="toki-logo.png" class="header__logo">
				<div class="bp3-navbar-heading header__title">Kompetisi Tim Olimpiade Komputer Indonesia</div>
			</div>
		</div>
	</nav>

	<div class="menubar">
		<div class="menubar__content">
			<div class="bp3-tabs">
				<ul class="bp3-tab-list" role="tablist">
					<li
						class="bp3-tab"
						role="tab"
						aria-selected="true"
					>
						<a href="/">Kompetisi</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="app-content">
		<h3>Kompetisi</h3>
		<?= $table ?>
	</div>
</body>
</html>
