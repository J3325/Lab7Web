<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<!-- Form Pencarian dan Filter Kategori -->
<form id="search-form" class="form-search mb-3 d-flex align-items-center gap-2">
    <select name="kategori_id" id="category-filter" class="form-select w-auto">
        <option value="">Kategori</option>
        <?php foreach ($kategori as $kat): ?>
            <option value="<?= $kat['id_kategori']; ?>" <?= ($kategori_id == $kat['id_kategori']) ? 'selected' : ''; ?>>
                <?= esc($kat['nama_kategori']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="q" id="search-box" value="<?= esc($q); ?>" placeholder="Cari data" class="form-control w-auto">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>

<!-- Kontainer Artikel dan Pagination -->
<div id="article-container"></div>
<div id="pagination-container" class="mt-3"></div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    function fetchData(url = '/admin/artikel') {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                renderArticles(data.artikel, data.pager_links);
                // renderPagination(data.pager_links);
            }
        });
    }

    function renderArticles(articles, pagerHtml) {
        let html = '<table class="table table-bordered">';
        html += `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead><tbody>
        `;

        if (articles.length > 0) {
            articles.forEach(article => {
                html += `
                    <tr>
                        <td>${article.id}</td>
                        <td>
                            <b>${article.judul}</b>
                            <p><small>${article.isi.substring(0, 50)}</small></p>
                        </td>
                        <td>${article.nama_kategori}</td>
                        <td>${article.status}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                            <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5" class="text-center">Belum ada data.</td></tr>';
        }

        html += '</tbody></table>';

        // Tambahkan pagination di bawah tabel
        html += `<div class="pagination-container mt-3">${pagerHtml || ''}</div>`;

        articleContainer.html(html);
    }

    function renderPagination(pagerHtml) {
        paginationContainer.html(pagerHtml || '');
    }
    // Form pencarian
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}`);
    });

    // Trigger submit saat ganti kategori
    categoryFilter.on('change', function() {
        searchForm.trigger('submit');
    });

    // Tangani klik pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        fetchData(url);
    });

    // Muat awal
    fetchData();
});
</script>

<?= $this->include('template/admin_footer'); ?>