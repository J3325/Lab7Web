<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="contact-section">
    <h1>Hubungi Kami</h1>
    <p class="contact-desc">
        Jika Anda memiliki pertanyaan, saran, atau ingin bekerja sama, jangan ragu untuk menghubungi kami melalui formulir di bawah ini.
    </p>

    <div class="contact-wrapper">
        <div class="contact-info">
            <h3>📍 Alamat</h3>
            <p>Jl. Teknologi No.123, Bekasi, Jawa Barat</p>

            <h3>📞 Telepon</h3>
            <p>+62 812 3456 7890</p>

            <h3>✉️ Email</h3>
            <p>info@webkamu.com</p>
        </div>

        <div class="contact-form">
            <form>
                <label for="nama">Nama</label>
                <input type="text" id="nama" placeholder="Nama Anda">

                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Email Anda">

                <label for="pesan">Pesan</label>
                <textarea id="pesan" rows="5" placeholder="Tulis pesan Anda..."></textarea>

                <button type="submit" class="btn-primary">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
