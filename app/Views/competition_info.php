<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
  <ul>
    <li>Tempat: <?= $competition['City'] ?>, <?= $competition['HostName'] ?></li>
    <li>Waktu: <?= date_format(date_create($competition['DateBegin']), 'd M Y') . ' &ndash; ' . date_format(date_create($competition['DateEnd']), 'd M Y') ?></li>
    <?php if ($competition['Website']) : ?>
      <li>Website: <a href="<?= $competition['Website'] ?>"><?= $competition['Website'] ?></a></li>
    <?php endif ?>
    <?php if ($competition['Contestants']) : ?>
      <li>Peserta: <?= $competition['Contestants'] ?></li>
    <?php endif ?>
    <?php if ($competition['Provinces']) : ?>
      <li>Provinsi: <?= $competition['Provinces'] ?></li>
    <?php endif ?>
  </ul>
<?= $this->endSection() ?>
