<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\CategoryModel;
use App\Models\UnitModel;

class Item extends BaseController
{
    protected $itemModel;
    protected $categoryModel;
    protected $unitModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->categoryModel = new CategoryModel();
        $this->unitModel = new UnitModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->itemModel
            ->select('
                p_item.*,
                p_category.name AS category_name,
                p_unit.name AS unit_name
            ')
            ->join(
                'p_category',
                'p_category.category_id = p_item.category_id'
            )
            ->join(
                'p_unit',
                'p_unit.unit_id = p_item.unit_id'
            );

        if ($keyword) {
            $builder->groupStart()
                ->like('p_item.barcode', $keyword)
                ->orLike('p_item.name', $keyword)
                ->orLike('p_category.name', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Produk',
            'items' => $builder
                ->orderBy('p_item.item_id', 'DESC')
                ->paginate(10),
            'pager' => $this->itemModel->pager,
            'keyword' => $keyword,
        ];

        return view('item/index', $data);
    }

    public function create()
    {
        return view('item/create', [
            'title' => 'Tambah Produk',
            'categories' => $this->categoryModel
                ->orderBy('name', 'ASC')
                ->findAll(),
            'units' => $this->unitModel
                ->orderBy('name', 'ASC')
                ->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'barcode' => [
                'label' => 'Barcode',
                'rules' => 'permit_empty|max_length[100]',
                'errors' => [
                    'max_length' => '{field} maksimal 100 karakter.',
                ],
            ],

            'name' => [
                'label' => 'Nama produk',
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 2 karakter.',
                    'max_length' => '{field} maksimal 100 karakter.',
                ],
            ],

            'category_id' => [
                'label' => 'Kategori',
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Kategori wajib dipilih.',
                ],
            ],

            'unit_id' => [
                'label' => 'Satuan',
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Satuan wajib dipilih.',
                ],
            ],

            'price_a' => [
                'label' => 'Harga modal',
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Harga modal wajib diisi.',
                    'is_natural' => 'Harga modal harus berupa angka.',
                ],
            ],

            'price' => [
                'label' => 'Harga jual',
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Harga jual wajib diisi.',
                    'is_natural' => 'Harga jual harus berupa angka.',
                ],
            ],

            'stock' => [
                'label' => 'Stok',
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Stok wajib diisi.',
                    'is_natural' => 'Stok harus berupa angka.',
                ],
            ],

            'min_stock' => [
                'label' => 'Minimum stok',
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Minimum stok wajib diisi.',
                    'is_natural' => 'Minimum stok harus berupa angka.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $barcode = trim($this->request->getPost('barcode'));

        if ($barcode !== '') {
            $existing = $this->itemModel
                ->where('barcode', $barcode)
                ->first();

            if ($existing) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Barcode sudah digunakan oleh produk lain.'
                    );
            }
        } else {
            $barcode = null;
        }

        $priceA = (int) $this->request->getPost('price_a');
        $price = (int) $this->request->getPost('price');

        if ($price < $priceA) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Harga jual tidak boleh lebih kecil dari harga modal.'
                );
        }

        $this->itemModel->insert([
            'barcode' => $barcode,
            'name' => trim($this->request->getPost('name')),
            'category_id' => (int) $this->request->getPost('category_id'),
            'unit_id' => (int) $this->request->getPost('unit_id'),
            'price_a' => $priceA,
            'price' => $price,
            'stock' => (int) $this->request->getPost('stock'),
            'min_stock' => (int) $this->request->getPost('min_stock'),
        ]);

        return redirect()
            ->to('/item')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = $this->itemModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/item')
                ->with('error', 'Produk tidak ditemukan.');
        }

        return view('item/edit', [
            'title' => 'Edit Produk',
            'item' => $item,
            'categories' => $this->categoryModel
                ->orderBy('name', 'ASC')
                ->findAll(),
            'units' => $this->unitModel
                ->orderBy('name', 'ASC')
                ->findAll(),
        ]);
    }

    public function update($id)
    {
        $item = $this->itemModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/item')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'barcode' => 'permit_empty|max_length[100]',
            'name' => 'required|min_length[2]|max_length[100]',
            'category_id' => 'required|is_natural_no_zero',
            'unit_id' => 'required|is_natural_no_zero',
            'price_a' => 'required|is_natural',
            'price' => 'required|is_natural',
            'stock' => 'required|is_natural',
            'min_stock' => 'required|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $barcode = trim($this->request->getPost('barcode'));

        if ($barcode !== '') {
            $existing = $this->itemModel
                ->where('barcode', $barcode)
                ->where('item_id !=', $id)
                ->first();

            if ($existing) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Barcode sudah digunakan oleh produk lain.'
                    );
            }
        } else {
            $barcode = null;
        }

        $priceA = (int) $this->request->getPost('price_a');
        $price = (int) $this->request->getPost('price');

        if ($price < $priceA) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Harga jual tidak boleh lebih kecil dari harga modal.'
                );
        }

        $this->itemModel->update($id, [
            'barcode' => $barcode,
            'name' => trim($this->request->getPost('name')),
            'category_id' => (int) $this->request->getPost('category_id'),
            'unit_id' => (int) $this->request->getPost('unit_id'),
            'price_a' => $priceA,
            'price' => $price,
            'stock' => (int) $this->request->getPost('stock'),
            'min_stock' => (int) $this->request->getPost('min_stock'),
        ]);

        return redirect()
            ->to('/item')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $item = $this->itemModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/item')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $db = db_connect();

        $saleDetail = $db->table('t_sale_detail')
            ->where('item_id', $id)
            ->countAllResults();

        $cart = $db->table('t_cart')
            ->where('item_id', $id)
            ->countAllResults();

        $stockTransaction = $db->table('t_stock')
            ->where('item_id', $id)
            ->countAllResults();

        if (
            $saleDetail > 0 ||
            $cart > 0 ||
            $stockTransaction > 0
        ) {
            return redirect()
                ->to('/item')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena sudah memiliki transaksi.'
                );
        }

        $this->itemModel->delete($id);

        return redirect()
            ->to('/item')
            ->with('success', 'Produk berhasil dihapus.');
    }
}