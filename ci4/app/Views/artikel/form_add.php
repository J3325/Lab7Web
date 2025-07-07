<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data" style="width: 100%; max-width: 800px;">
    <p>
        <label for="judul">Judul</label>
        <input 
            type="text" 
            name="judul" 
            id="judul" 
            placeholder="Judul Artikel" 
            style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;"
            required
        >
    </p>

    <p>
        <label for="isi">Isi</label>
        <textarea 
            name="isi" 
            id="isi" 
            cols="50" 
            rows="10" 
            placeholder="Isi Artikel"
            style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;"
            required
        ></textarea>
    </p>

    <p>
        <label for="id_kategori">Kategori</label>
        <select 
            name="id_kategori" 
            id="id_kategori"
            style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;" 
            required
        >
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="gambar">Gambar</label>
        <input 
            type="file" 
            name="gambar" 
            id="gambar"
            style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;"
        >
    </p>

    <p>
        <input 
            type="submit" 
            value="Kirim" 
            class="btn btn-large" 
            style="width: 10%; padding: 10px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;"
        >
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
