<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Filter Dropdown Kategori -->
<h3>Filter Kategori</h3>
<form method="get" class="form-inline mb-3">
    <select name="kategori_id" class="form-control" onchange="this.form.submit()">
        <option value=""> Semua Kategori </option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                <?= esc($k['nama_kategori']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<hr class="divider" />

<!-- Daftar Artikel -->
<div class="artikel-list">
<?php if ($artikel) : ?>
    <?php foreach ($artikel as $row) : ?>
        <div class="artikel-card">
            <?php if (!empty($row['gambar'])) : ?>
                <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= esc($row['judul']); ?>" class="artikel-card-img">
            <?php endif; ?>

            <div class="artikel-card-content">
                <div class="artikel-card-title">
                    <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
                        <?= esc($row['judul']); ?>
                    </a>
                </div>
                <div class="artikel-kategori">
                    Kategori: <?= esc($row['nama_kategori']); ?>
                </div>
                <div class="artikel-ringkasan">
                    <?= esc(substr($row['isi'], 0, 200)); ?>...
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="artikel-kosong">
        <h2>Belum ada data.</h2>
    </div>
<?php endif; ?>
</div>

<?= $this->endSection() ?>