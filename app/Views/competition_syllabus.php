<?= $this->extend('competition') ?>

<?= $this->section('subcontent') ?>
    <?php if (file_exists(APPPATH . 'Views/' . $competition['ID'] . '/syllabus.php')): ?>
        <?= $this->include($competition['ID'] . '/syllabus'); ?>
    <?php endif; ?>
<?= $this->endSection() ?>
