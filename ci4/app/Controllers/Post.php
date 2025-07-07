<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Post extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->select('artikel.*, kategori.nama_kategori')
                                 ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                                 ->orderBy('artikel.id', 'DESC')
                                 ->findAll();
        return $this->respond($data);
    }

    public function kategori()
    {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        $model = new ArtikelModel();

        $gambar = $this->request->getFile('gambar');
        $namaGambar = '';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/gambar', $namaGambar);
        }

        $data = [
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'status'      => $this->request->getPost('status') ?? 0,
            'id_kategori' => $this->request->getPost('id_kategori'),
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'gambar'      => $namaGambar,
        ];

        if (!$model->insert($data)) {
            return $this->failValidationErrors($model->errors());
        }

        return $this->respondCreated(['message' => 'Artikel berhasil ditambahkan']);
    }

    public function update($id = null)
    {
        $model = new ArtikelModel();
        $dataLama = $model->find($id);
        if (!$dataLama) return $this->failNotFound('Data tidak ditemukan');

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $dataLama['gambar']; // default: pakai yang lama

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/gambar', $namaGambar);
        }

        $data = [
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'status'      => $this->request->getPost('status') ?? 0,
            'id_kategori' => $this->request->getPost('id_kategori'),
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'gambar'      => $namaGambar,
        ];

        if (!$model->update($id, $data)) {
            return $this->failValidationErrors($model->errors());
        }

        return $this->respond(['message' => 'Artikel berhasil diubah']);
    }

    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);
        if (!$data) return $this->failNotFound('Data tidak ditemukan');

        // Hapus file gambar dari public/gambar
        if (!empty($data['gambar']) && file_exists(ROOTPATH . 'public/gambar/' . $data['gambar'])) {
            unlink(ROOTPATH . 'public/gambar/' . $data['gambar']);
        }

        $model->delete($id);

        return $this->respondDeleted(['message' => 'Artikel berhasil dihapus']);
    }
}