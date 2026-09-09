<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $keyword = trim($this->request->getGet('keyword'));

        $builder = $this->customerModel;

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('name', $keyword)
                ->orLike('phone', $keyword)
                ->orLike('address', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Customer',
            'customers' => $builder
                ->orderBy('customer_id', 'DESC')
                ->paginate(10),
            'pager' => $this->customerModel->pager,
            'keyword' => $keyword,
        ];

        return view('customer/index', $data);
    }

    public function create()
    {
        return view('customer/create', [
            'title' => 'Tambah Customer',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'label' => 'Nama customer',
                'rules' => 'required|min_length[2]|max_length[100]',
            ],

            'gender' => [
                'label' => 'Jenis kelamin',
                'rules' => 'required|in_list[L,P]',
            ],

            'phone' => [
                'label' => 'No. HP',
                'rules' => 'required|max_length[15]',
            ],

            'address' => [
                'label' => 'Alamat',
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->insert([
            'name' => trim($this->request->getPost('name')),
            'gender' => $this->request->getPost('gender'),
            'phone' => trim($this->request->getPost('phone')),
            'address' => trim($this->request->getPost('address')),
        ]);

        return redirect()
            ->to('/customer')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to('/customer')
                ->with('error', 'Customer tidak ditemukan.');
        }

        return view('customer/edit', [
            'title' => 'Edit Customer',
            'customer' => $customer,
        ]);
    }

    public function update($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to('/customer')
                ->with('error', 'Customer tidak ditemukan.');
        }

        $rules = [
            'name' => [
                'label' => 'Nama customer',
                'rules' => 'required|min_length[2]|max_length[100]',
            ],

            'gender' => [
                'label' => 'Jenis kelamin',
                'rules' => 'required|in_list[L,P]',
            ],

            'phone' => [
                'label' => 'No. HP',
                'rules' => 'required|max_length[15]',
            ],

            'address' => [
                'label' => 'Alamat',
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->update($id, [
            'name' => trim($this->request->getPost('name')),
            'gender' => $this->request->getPost('gender'),
            'phone' => trim($this->request->getPost('phone')),
            'address' => trim($this->request->getPost('address')),
        ]);

        return redirect()
            ->to('/customer')
            ->with('success', 'Customer berhasil diperbarui.');
    }

    public function delete($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to('/customer')
                ->with('error', 'Customer tidak ditemukan.');
        }

        $db = db_connect();

        $used = $db->table('t_sale')
            ->where('customer_id', $id)
            ->countAllResults();

        if ($used > 0) {
            return redirect()
                ->to('/customer')
                ->with(
                    'error',
                    'Customer tidak dapat dihapus karena sudah memiliki transaksi.'
                );
        }

        $this->customerModel->delete($id);

        return redirect()
            ->to('/customer')
            ->with('success', 'Customer berhasil dihapus.');
    }
}