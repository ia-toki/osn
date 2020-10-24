<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
  <ul>
    <li>Tempat: <?= $competitionCity ?>, <?= $competitionHostName ?></li>
    <li>Waktu: <?= date_format(date_create($competitionDateBegin), 'd M Y') . ' &ndash; ' . date_format(date_create($competitionDateEnd), 'd M Y') ?></li>
    <?php if ($competitionWebsite) : ?>
      <li>Website: <a href="<?= $competitionWebsite ?>"><?= $competitionWebsite ?></a></li>
    <?php endif ?>
    <?php if ($competitionContestants) : ?>
      <li>Peserta: <?= $competitionContestants ?></li>
    <?php endif ?>
    <?php if ($competitionProvinces) : ?>
      <li>Provinsi: <?= $competitionProvinces ?></li>
    <?php endif ?>
  </ul>
<?= $this->endSection() ?>
