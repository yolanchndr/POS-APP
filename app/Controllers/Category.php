<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Kategori',
            'categories' => $this->categoryModel
                ->orderBy('category_id', 'DESC')
                ->findAll(),
        ];

        return view('category/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
        ];

        return view('category/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'label'  => 'Nama kategori',
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 2 karakter.',
                    'max_length' => '{field} maksimal 100 karakter.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));

        $existing = $this->categoryModel
            ->where('name', $name)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kategori tersebut sudah ada.');
        }

        $this->categoryModel->insert([
            'name' => $name,
        ]);

        return redirect()
            ->to('/category')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()
                ->to('/category')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $data = [
            'title'    => 'Edit Kategori',
            'category' => $category,
        ];

        return view('category/edit', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()
                ->to('/category')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'name' => [
                'label'  => 'Nama kategori',
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 2 karakter.',
                    'max_length' => '{field} maksimal 100 karakter.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));

        $existing = $this->categoryModel
            ->where('name', $name)
            ->where('category_id !=', $id)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kategori tersebut sudah ada.');
        }

        $this->categoryModel->update($id, [
            'name' => $name,
        ]);

        return redirect()
            ->to('/category')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()
                ->to('/category')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        // Cek apakah kategori sudah digunakan produk
        $db = db_connect();

        $product = $db->table('p_item')
            ->where('category_id', $id)
            ->countAllResults();

        if ($product > 0) {
            return redirect()
                ->to('/category')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena sudah digunakan oleh produk.'
                );
        }

        $this->categoryModel->delete($id);

        return redirect()
            ->to('/category')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}