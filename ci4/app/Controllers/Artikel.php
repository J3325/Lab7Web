<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if (!empty($kategori_id)) {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $artikel = $builder->get()->getResultArray();
        $kategori = $kategoriModel->findAll();

        return view('artikel/index', compact('artikel', 'title', 'kategori', 'kategori_id'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        $model = new ArtikelModel();

        // Query builder dengan join kategori
        $builder = $model->table('artikel')
                        ->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if (!empty($q)) {
            $builder->like('artikel.judul', $q);
        }

        if (!empty($kategori_id)) {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Pagination 3 per halaman
        $perPage = 3;
        $artikel = $builder->paginate($perPage);
        $pager = $model->pager;

        $data = [
            'title'       => $title,
            'artikel'     => $artikel,
            'pager'       => $pager,
            'q'           => $q,
            'kategori_id' => $kategori_id,
        ];

        if ($this->request->isAJAX()) {
            // Ambil HTML pagination-nya sebagai string
            $pagerLinks = $pager->only(['q', 'kategori_id'])->links('default', 'custom_pagination');

            $data['pager_links'] = $pagerLinks;

            return $this->response->setJSON($data);
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();

            return view('artikel/admin_index', $data);
        }
    }

    public function add()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'judul'       => 'required',
            'id_kategori' => 'required|integer',
        ];

        if ($this->request->getMethod() == 'POST' && $this->validate($rules)) {
            $model = new ArtikelModel();

            $gambar = null;
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $file->move(ROOTPATH . 'public/gambar');
                $gambar = $file->getName();
            }

            $model->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul'), '-', true),
                'gambar'      => $gambar,
                'id_kategori' => $this->request->getPost('id_kategori'),
            ]);

            return redirect()->to('/admin/artikel');
        } else {
            $kategoriModel = new KategoriModel();
            $kategori = $kategoriModel->findAll();
            $title = "Tambah Artikel";

            return view('artikel/form_add', compact('title', 'kategori'));
        }
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        $rules = [
            'judul'       => 'required',
            'id_kategori' => 'required|integer',
        ];

        if ($this->request->getMethod() == 'POST' && $this->validate($rules)) {
            $updateData = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'slug'        => url_title($this->request->getPost('judul'), '-', true),
            ];

            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $file->move(ROOTPATH . 'public/gambar');
                $updateData['gambar'] = $file->getName();
            }

            $model->update($id, $updateData);
            return redirect()->to('/admin/artikel');
        } else {
            $artikel = $model->find($id);
            $kategoriModel = new KategoriModel();
            $kategori = $kategoriModel->findAll();
            $title = "Edit Artikel";

            return view('artikel/form_edit', compact('title', 'artikel', 'kategori'));
        }
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where('slug', $slug)->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function kategori($slug_kategori)
    {
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $artikel = $model->getArtikelByKategori($slug_kategori);
        $kategori = $kategoriModel->getAllKategori();

        $title = 'Artikel Berdasarkan Kategori';

        return view('artikel/index', compact('artikel', 'title', 'kategori'));
    }

}