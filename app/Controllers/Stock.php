<?php

namespace App\Controllers;

use App\Models\StockModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;

class Stock extends BaseController
{
    protected $stockModel;
    protected $productModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
        $this->productModel = new ProductModel();
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $keyword = trim($this->request->getGet('keyword'));

        $builder = $this->stockModel
            ->select('
                t_stock.*,
                p_item.name AS item_name,
                p_item.barcode,
                supplier.name AS supplier_name,
                user.name AS user_name
            ')
            ->join(
                'p_item',
                'p_item.item_id = t_stock.item_id',
                'left'
            )
            ->join(
                'supplier',
                'supplier.supplier_id = t_stock.supplier_id',
                'left'
            )
            ->join(
                'user',
                'user.user_id = t_stock.user_id',
                'left'
            );

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('p_item.name', $keyword)
                ->orLike('p_item.barcode', $keyword)
                ->orLike('supplier.name', $keyword)
                ->orLike('t_stock.detail', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Stok',
            'stocks' => $builder
                ->orderBy('t_stock.stock_id', 'DESC')
                ->paginate(15),
            'pager' => $this->stockModel->pager,
            'keyword' => $keyword,
        ];

        return view('stock/index', $data);
    }

    public function masuk()
    {
        $data = [
            'title' => 'Stok Masuk',
            'products' => $this->productModel
                ->orderBy('name', 'ASC')
                ->findAll(),

            'suppliers' => $this->supplierModel
                ->orderBy('name', 'ASC')
                ->findAll(),
        ];

        return view('stock/masuk', $data);
    }

    public function storeMasuk()
    {
        $rules = [
            'item_id' => [
                'label' => 'Barang',
                'rules' => 'required|is_natural_no_zero',
            ],

            'supplier_id' => [
                'label' => 'Supplier',
                'rules' => 'required|is_natural_no_zero',
            ],

            'qty' => [
                'label' => 'Jumlah',
                'rules' => 'required|is_natural_no_zero',
            ],

            'detail' => [
                'label' => 'Detail',
                'rules' => 'required|max_length[200]',
            ],

            'date' => [
                'label' => 'Tanggal',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $itemId = (int) $this->request->getPost('item_id');
        $supplierId = (int) $this->request->getPost('supplier_id');
        $qty = (int) $this->request->getPost('qty');

        $item = $this->productModel->find($itemId);

        if (!$item) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Barang tidak ditemukan.');
        }

        $supplier = $this->supplierModel->find($supplierId);

        if (!$supplier) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Supplier tidak ditemukan.');
        }

        $db = db_connect();

        $db->transStart();

        /*
         * 1. Tambahkan stok barang
         */
        $db->table('p_item')
            ->where('item_id', $itemId)
            ->set('stock', 'stock + ' . $qty, false)
            ->update();

        /*
         * 2. Simpan riwayat stok
         */
        $db->table('t_stock')->insert([
            'item_id' => $itemId,
            'type' => 'in',
            'detail' => trim(
                $this->request->getPost('detail')
            ),
            'supplier_id' => $supplierId,
            'qty' => $qty,
            'ket_stok' => $this->request->getPost('ket_stok'),
            'date' => $this->request->getPost('date'),
            'user_id' => session()->get('user_id'),
            'status_stock' => 'diterima',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan transaksi stok.'
                );
        }

        return redirect()
            ->to('/stock')
            ->with(
                'success',
                'Stok berhasil ditambahkan sebanyak ' . $qty . ' unit.'
            );
    }

    public function keluar()
    {
        $data = [
            'title' => 'Stok Keluar',

            'products' => $this->productModel
                ->orderBy('name', 'ASC')
                ->findAll(),
        ];

        return view('stock/keluar', $data);
    }

    public function storeKeluar()
    {
        $rules = [
            'item_id' => [
                'label' => 'Barang',
                'rules' => 'required|is_natural_no_zero',
            ],

            'qty' => [
                'label' => 'Jumlah',
                'rules' => 'required|is_natural_no_zero',
            ],

            'detail' => [
                'label' => 'Detail',
                'rules' => 'required|max_length[200]',
            ],

            'date' => [
                'label' => 'Tanggal',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $itemId = (int) $this->request->getPost('item_id');
        $qty = (int) $this->request->getPost('qty');

        $item = $this->productModel->find($itemId);

        if (!$item) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Barang tidak ditemukan.');
        }

        /*
        * Pastikan stok mencukupi
        */
        if ((int) $item['stock'] < $qty) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Stok tidak mencukupi. Stok tersedia: ' .
                    $item['stock']
                );
        }

        $db = db_connect();

        $db->transStart();

        /*
        * Kurangi stok
        */
        $db->table('p_item')
            ->where('item_id', $itemId)
            ->set('stock', 'stock - ' . $qty, false)
            ->update();

        /*
        * Simpan riwayat stok
        */
        $db->table('t_stock')->insert([
            'item_id' => $itemId,
            'type' => 'out',
            'detail' => trim(
                $this->request->getPost('detail')
            ),
            'supplier_id' => null,
            'qty' => $qty,
            'ket_stok' => $this->request->getPost('ket_stok'),
            'date' => $this->request->getPost('date'),
            'user_id' => session()->get('user_id'),
            'status_stock' => 'diterima',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan transaksi stok keluar.'
                );
        }

        return redirect()
            ->to('/stock')
            ->with(
                'success',
                'Stok berhasil dikeluarkan sebanyak ' .
                $qty .
                ' unit.'
            );
    }
}