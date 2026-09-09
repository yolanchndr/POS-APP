<?php

namespace App\Controllers;

use App\Models\UnitModel;

class Unit extends BaseController
{
    protected $unitModel;

    public function __construct()
    {
        $this->unitModel = new UnitModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Satuan',
            'units' => $this->unitModel
                ->orderBy('unit_id', 'DESC')
                ->findAll(),
        ];

        return view('unit/index', $data);
    }

    public function create()
    {
        return view('unit/create', [
            'title' => 'Tambah Satuan',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'label' => 'Nama satuan',
                'rules' => 'required|min_length[1]|max_length[100]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
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

        $existing = $this->unitModel
            ->where('name', $name)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Satuan tersebut sudah ada.');
        }

        $this->unitModel->insert([
            'name' => $name,
        ]);

        return redirect()
            ->to('/unit')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $unit = $this->unitModel->find($id);

        if (!$unit) {
            return redirect()
                ->to('/unit')
                ->with('error', 'Satuan tidak ditemukan.');
        }

        return view('unit/edit', [
            'title' => 'Edit Satuan',
            'unit' => $unit,
        ]);
    }

    public function update($id)
    {
        $unit = $this->unitModel->find($id);

        if (!$unit) {
            return redirect()
                ->to('/unit')
                ->with('error', 'Satuan tidak ditemukan.');
        }

        $rules = [
            'name' => [
                'label' => 'Nama satuan',
                'rules' => 'required|min_length[1]|max_length[100]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
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

        $existing = $this->unitModel
            ->where('name', $name)
            ->where('unit_id !=', $id)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Satuan tersebut sudah ada.');
        }

        $this->unitModel->update($id, [
            'name' => $name,
        ]);

        return redirect()
            ->to('/unit')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $unit = $this->unitModel->find($id);

        if (!$unit) {
            return redirect()
                ->to('/unit')
                ->with('error', 'Satuan tidak ditemukan.');
        }

        // Cek apakah satuan sudah digunakan produk
        $db = db_connect();

        $product = $db->table('p_item')
            ->where('unit_id', $id)
            ->countAllResults();

        if ($product > 0) {
            return redirect()
                ->to('/unit')
                ->with(
                    'error',
                    'Satuan tidak dapat dihapus karena sudah digunakan oleh produk.'
                );
        }

        $this->unitModel->delete($id);

        return redirect()
            ->to('/unit')
            ->with('success', 'Satuan berhasil dihapus.');
    }
}