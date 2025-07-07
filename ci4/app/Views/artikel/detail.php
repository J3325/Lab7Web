<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="artikel-detail">
    <h1 class="artikel-detail-title"><?= esc($artikel['judul']); ?></h1>

    <?php if (!empty($artikel['gambar'])) : ?>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= esc($artikel['judul']); ?>" class="artikel-detail-img">
    <?php endif; ?>

    <div class="artikel-detail-body">
        <?= esc($artikel['isi']); ?>
    </div>
</div>

<?= $this->endSection() ?>
