<?= $this->extend('statistics') ?>

<?= $this->section('subcontent') ?>
  <div class="bp3-card subcontent">
    <h3><?= $province['Name'] ?></h3>
    <hr />
    <?= $table ?>
  </div>
<?= $this->endSection() ?>
