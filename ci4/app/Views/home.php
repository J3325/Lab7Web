<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="hero">
    <div class="hero-text">
        <h1>Selamat Datang di Website Kami</h1>
        <p>Eksplorasi artikel menarik, belajar hal baru, dan tetap terinspirasi setiap hari.</p>
        <a href="<?= base_url('/artikel'); ?>" class="btn-primary">Lihat Artikel</a>
    </div>
</div>

<div class="features">
    <div class="feature-box">
        <h3>📘 Artikel Terbaru</h3>
        <p>Dapatkan update konten terkini seputar teknologi, edukasi, dan lainnya.</p>
    </div>
    <div class="feature-box">
        <h3>💡 Tips & Tutorial</h3>
        <p>Belajar secara mandiri dengan panduan mudah dan praktis dari kami.</p>
    </div>
    <div class="feature-box">
        <h3>🌐 Komunitas</h3>
        <p>Bergabung dalam komunitas kami dan tumbuh bersama.</p>
    </div>
</div>
<div class="gif-section">
    <h2 style="text-align: center; margin-top: 60px;">ENJOY IN THIS WEBSITE</h2>
    <img src="https://i.pinimg.com/originals/4c/b9/3a/4cb93a19705f37e6a68a8eec9d59af7f.gif" 
         alt="Motivasi Ngoding" 
         class="gif-banner">
    </div>
<?= $this->endSection() ?>
