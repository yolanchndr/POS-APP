<?php

namespace App\Controllers;

use App\Models\SupplierModel;

class Supplier extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $keyword = trim($this->request->getGet('keyword'));

        $builder = $this->supplierModel;

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('name', $keyword)
                ->orLike('phone', $keyword)
                ->orLike('address', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Supplier',
            'suppliers' => $builder
                ->orderBy('supplier_id', 'DESC')
                ->paginate(10),
            'pager' => $this->supplierModel->pager,
            'keyword' => $keyword,
        ];

        return view('supplier/index', $data);
    }

    public function create()
    {
        return view('supplier/create', [
            'title' => 'Tambah Supplier',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'label' => 'Nama supplier',
                'rules' => 'required|min_length[2]|max_length[100]',
            ],

            'phone' => [
                'label' => 'No. HP',
                'rules' => 'required|max_length[16]',
            ],

            'address' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
            ],

            'desc' => [
                'label' => 'Keterangan',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->insert([
            'name' => trim($this->request->getPost('name')),
            'phone' => trim($this->request->getPost('phone')),
            'address' => trim($this->request->getPost('address')),
            'desc' => trim($this->request->getPost('desc')),
        ]);

        return redirect()
            ->to('/supplier')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()
                ->to('/supplier')
                ->with('error', 'Supplier tidak ditemukan.');
        }

        return view('supplier/edit', [
            'title' => 'Edit Supplier',
            'supplier' => $supplier,
        ]);
    }

    public function update($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()
                ->to('/supplier')
                ->with('error', 'Supplier tidak ditemukan.');
        }

        $rules = [
            'name' => [
                'label' => 'Nama supplier',
                'rules' => 'required|min_length[2]|max_length[100]',
            ],

            'phone' => [
                'label' => 'No. HP',
                'rules' => 'required|max_length[16]',
            ],

            'address' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
            ],

            'desc' => [
                'label' => 'Keterangan',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->update($id, [
            'name' => trim($this->request->getPost('name')),
            'phone' => trim($this->request->getPost('phone')),
            'address' => trim($this->request->getPost('address')),
            'desc' => trim($this->request->getPost('desc')),
        ]);

        return redirect()
            ->to('/supplier')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function delete($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()
                ->to('/supplier')
                ->with('error', 'Supplier tidak ditemukan.');
        }

        $db = db_connect();

        $used = $db->table('t_stock')
            ->where('supplier_id', $id)
            ->countAllResults();

        if ($used > 0) {
            return redirect()
                ->to('/supplier')
                ->with(
                    'error',
                    'Supplier tidak dapat dihapus karena sudah digunakan pada transaksi stok.'
                );
        }

        $this->supplierModel->delete($id);

        return redirect()
            ->to('/supplier')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}