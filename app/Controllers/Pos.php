<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\CartModel;
use App\Models\SaleModel;
use App\Models\SaleDetailModel;
use App\Models\SettingModel; // 1. Tambahkan use SettingModel

class Pos extends BaseController
{
    protected $productModel;
    protected $customerModel;
    protected $cartModel;
    protected $saleModel;
    protected $saleDetailModel;
    protected $settingModel; // 2. Deklarasikan properti settingModel

    public function __construct()
    {
        $this->productModel    = new ProductModel();
        $this->customerModel   = new CustomerModel();
        $this->cartModel       = new CartModel();
        $this->saleModel       = new SaleModel();
        $this->saleDetailModel = new SaleDetailModel();
        $this->settingModel    = new SettingModel(); // 3. Inisialisasi model di constructor
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $cart = $this->cartModel
            ->select('t_cart.*, p_item.name AS item_name, p_item.barcode, p_item.stock')
            ->join('p_item', 'p_item.item_id = t_cart.item_id')
            ->where('t_cart.user_id', $userId)
            ->orderBy('t_cart.cart_id', 'ASC')
            ->findAll();

        $customers = $this->customerModel->orderBy('name', 'ASC')->findAll();
        $products  = $this->productModel->where('stock >', 0)->orderBy('name', 'ASC')->findAll();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += (int) $item['total'];
        }

        $data = [
            'title'     => 'Kasir',
            'cart'      => $cart,
            'customers' => $customers,
            'products'  => $products,
            'subtotal'  => $subtotal,
        ];

        return view('pos/index', $data);
    }

    public function addCart()
    {
        $userId = session()->get('user_id');
        $itemId = (int) $this->request->getPost('item_id');
        $qty    = max(1, (int) $this->request->getPost('qty'));

        $item = $this->productModel->find($itemId);

        if (!$item) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        if ((int) $item['stock'] < $qty) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $item['stock']);
        }

        $existing = $this->cartModel
            ->where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();

        if ($existing) {
            $newQty = (int) $existing['qty'] + $qty;

            if ($newQty > (int) $item['stock']) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }

            $discount = (int) $existing['discount_item'];
            $price    = (int) $item['price'];
            $total    = ($price * $newQty) - $discount;

            $this->cartModel->update($existing['cart_id'], [
                'qty'   => $newQty,
                'price' => $price,
                'total' => max(0, $total),
            ]);
        } else {
            $price = (int) $item['price'];
            $total = $price * $qty;

            $this->cartModel->insert([
                'item_id'       => $itemId,
                'price'         => $price,
                'qty'           => $qty,
                'discount_item' => 0,
                'total'         => $total,
                'tot_price_a'   => $item['price_a'] * $qty,
                'user_id'       => $userId,
            ]);
        }

        return redirect()->to('/pos')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function updateCart($cartId)
    {
        $userId = session()->get('user_id');
        $cart   = $this->cartModel->where('cart_id', $cartId)->where('user_id', $userId)->first();

        if (!$cart) {
            return redirect()->to('/pos')->with('error', 'Data keranjang tidak ditemukan.');
        }

        $qty      = max(1, (int) $this->request->getPost('qty'));
        $discount = max(0, (int) $this->request->getPost('discount_item'));
        $item     = $this->productModel->find($cart['item_id']);

        if (!$item) {
            return redirect()->to('/pos')->with('error', 'Barang tidak ditemukan.');
        }

        if ($qty > (int) $item['stock']) {
            return redirect()->to('/pos')->with('error', 'Jumlah melebihi stok barang.');
        }

        $price = (int) $cart['price'];
        $total = max(0, ($price * $qty) - $discount);

        $this->cartModel->update($cartId, [
            'qty'           => $qty,
            'discount_item' => $discount,
            'total'         => $total,
            'tot_price_a'   => (int) $item['price_a'] * $qty,
        ]);

        return redirect()->to('/pos');
    }

    public function deleteCart($cartId)
    {
        $userId = session()->get('user_id');
        $this->cartModel->where('cart_id', $cartId)->where('user_id', $userId)->delete();

        return redirect()->to('/pos');
    }

    public function clearCart()
    {
        $userId = session()->get('user_id');
        $this->cartModel->where('user_id', $userId)->delete();

        return redirect()->to('/pos')->with('success', 'Keranjang dikosongkan.');
    }

    // --- FUNGSI AJAX ---

    public function barcode()
    {
        $barcode = trim($this->request->getGet('barcode'));

        if ($barcode === '') {
            return $this->response->setJSON(['success' => false, 'message' => 'Barcode kosong.']);
        }

        $item = $this->productModel->where('barcode', $barcode)->first();

        if (!$item) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk dengan barcode tersebut tidak ditemukan.']);
        }

        if ((int) $item['stock'] <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Stok produk habis.']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => [
                'item_id' => $item['item_id'],
                'barcode' => $item['barcode'],
                'name'    => $item['name'],
                'price'   => (int) $item['price'],
                'stock'   => (int) $item['stock'],
            ]
        ]);
    }

    public function addCartAjax()
    {
        $userId = session()->get('user_id');
        $itemId = (int) $this->request->getPost('item_id');
        $qty    = max(1, (int) $this->request->getPost('qty'));

        $item = $this->productModel->find($itemId);

        if (!$item) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan.']);
        }

        if ((int) $item['stock'] <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Stok produk habis.']);
        }

        $existing = $this->cartModel->where('user_id', $userId)->where('item_id', $itemId)->first();

        if ($existing) {
            $newQty = (int) $existing['qty'] + $qty;

            if ($newQty > (int) $item['stock']) {
                return $this->response->setJSON(['success' => false, 'message' => 'Jumlah melebihi stok tersedia.']);
            }

            $discount = (int) $existing['discount_item'];
            $price    = (int) $item['price'];
            $total    = max(0, ($price * $newQty) - $discount);

            $this->cartModel->update($existing['cart_id'], [
                'qty'         => $newQty,
                'price'       => $price,
                'total'       => $total,
                'tot_price_a' => (int) $item['price_a'] * $newQty,
            ]);
        } else {
            $price = (int) $item['price'];
            $total = $price * $qty;

            $this->cartModel->insert([
                'item_id'       => $itemId,
                'price'         => $price,
                'qty'           => $qty,
                'discount_item' => 0,
                'total'         => $total,
                'tot_price_a'   => (int) $item['price_a'] * $qty,
                'user_id'       => $userId,
            ]);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Produk berhasil ditambahkan.']);
    }

    public function cartAjax()
    {
        $userId = session()->get('user_id');

        $cart = $this->cartModel
            ->select('t_cart.*, p_item.name AS item_name, p_item.barcode, p_item.stock')
            ->join('p_item', 'p_item.item_id = t_cart.item_id')
            ->where('t_cart.user_id', $userId)
            ->orderBy('t_cart.cart_id', 'ASC')
            ->findAll();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += (int) $item['total'];
        }

        return $this->response->setJSON([
            'success'  => true,
            'cart'     => $cart,
            'subtotal' => $subtotal,
            'count'    => count($cart),
        ]);
    }

    public function updateCartAjax()
    {
        $userId   = session()->get('user_id');
        $cartId   = (int) $this->request->getPost('cart_id');
        $qty      = max(1, (int) $this->request->getPost('qty'));
        $discount = max(0, (int) $this->request->getPost('discount_item'));

        $cart = $this->cartModel->where('cart_id', $cartId)->where('user_id', $userId)->first();

        if (!$cart) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data cart tidak ditemukan.']);
        }

        $item = $this->productModel->find($cart['item_id']);

        if (!$item) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan.']);
        }

        if ($qty > (int) $item['stock']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Qty melebihi stok tersedia.']);
        }

        $price = (int) $cart['price'];
        $total = max(0, ($price * $qty) - $discount);

        $this->cartModel->update($cartId, [
            'qty'           => $qty,
            'discount_item' => $discount,
            'total'         => $total,
            'tot_price_a'   => (int) $item['price_a'] * $qty,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Cart diperbarui.']);
    }

    public function deleteCartAjax()
    {
        $userId = session()->get('user_id');
        $cartId = (int) $this->request->getPost('cart_id');

        $cart = $this->cartModel->where('cart_id', $cartId)->where('user_id', $userId)->first();

        if (!$cart) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cart tidak ditemukan.']);
        }

        $this->cartModel->delete($cartId);

        return $this->response->setJSON(['success' => true, 'message' => 'Produk dihapus dari cart.']);
    }

    // --- CHECKOUT & RECEIPT ---

    public function checkout()
    {
        $userId     = session()->get('user_id');
        $customerId = $this->request->getPost('customer_id') !== '' ? $this->request->getPost('customer_id') : null;
        $discount   = max(0, (int) $this->request->getPost('discount'));
        $cash       = max(0, (int) $this->request->getPost('cash'));
        $note       = trim($this->request->getPost('note') ?? '');

        $cart = $this->cartModel->where('user_id', $userId)->findAll();

        if (empty($cart)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Keranjang masih kosong.']);
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $subtotal   = 0;
            $totalModal = 0;

            foreach ($cart as &$cartItem) {
                $item = $db->query("SELECT * FROM p_item WHERE item_id = ? FOR UPDATE", [$cartItem['item_id']])->getRowArray();

                if (!$item) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ((int) $item['stock'] < (int) $cartItem['qty']) {
                    throw new \Exception('Stok produk "' . $item['name'] . '" tidak mencukupi. Stok tersedia: ' . $item['stock']);
                }

                $cartItem['current_price']   = (int) $item['price'];
                $cartItem['current_price_a'] = (int) $item['price_a'];
                $cartItem['total']           = max(0, ((int) $item['price'] * (int) $cartItem['qty']) - (int) $cartItem['discount_item']);

                $subtotal   += $cartItem['total'];
                $totalModal += ((int) $item['price_a'] * (int) $cartItem['qty']);
            }
            unset($cartItem);

            $finalPrice = max(0, $subtotal - $discount);

            if ($cash < $finalPrice) {
                throw new \Exception('Uang pembayaran kurang. Total: Rp ' . number_format($finalPrice, 0, ',', '.'));
            }

            $change  = $cash - $finalPrice;
            $invoice = 'INV-' . date('YmdHis') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

            $this->saleModel->insert([
                'invoice'        => $invoice,
                'customer_id'    => $customerId,
                'total_price'    => $subtotal,
                'tot_price_a'    => $totalModal,
                'discount'       => $discount,
                'final_price'    => $finalPrice,
                'cash'           => $cash,
                'uang_kembalian' => $change,
                'note'           => $note,
                'date'           => date('Y-m-d'),
                'user_id'        => $userId,
            ]);

            $saleId = $this->saleModel->getInsertID();

            foreach ($cart as $cartItem) {
                $this->saleDetailModel->insert([
                    'sale_id'       => $saleId,
                    'item_id'       => $cartItem['item_id'],
                    'price'         => $cartItem['current_price'],
                    'qty'           => $cartItem['qty'],
                    'discount_item' => $cartItem['discount_item'],
                    'total'         => $cartItem['total'],
                    'tot_price_a'   => $cartItem['current_price_a'] * $cartItem['qty'],
                ]);

                $db->table('p_item')
                    ->where('item_id', $cartItem['item_id'])
                    ->set('stock', 'stock - ' . (int) $cartItem['qty'], false)
                    ->update();

                $db->table('t_stock')->insert([
                    'item_id'      => $cartItem['item_id'],
                    'type'         => 'out',
                    'detail'       => 'Penjualan ' . $invoice,
                    'supplier_id'  => null,
                    'qty'          => $cartItem['qty'],
                    'ket_stok'     => 'Stok keluar karena transaksi penjualan',
                    'date'         => date('Y-m-d'),
                    'created'      => date('Y-m-d H:i:s'),
                    'user_id'      => $userId,
                    'status_stock' => 'diterima',
                ]);
            }

            $this->cartModel->where('user_id', $userId)->delete();

            if (!$db->transStatus()) {
                throw new \Exception('Gagal menyimpan transaksi.');
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'data'    => [
                    'sale_id'     => $saleId,
                    'invoice'     => $invoice,
                    'subtotal'    => $subtotal,
                    'discount'    => $discount,
                    'final_price' => $finalPrice,
                    'cash'        => $cash,
                    'change'      => $change,
                ]
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function receipt($saleId)
    {
        $sale = $this->saleModel
            ->select('t_sale.*, customer.name AS customer_name, user.name AS cashier_name')
            ->join('customer', 'customer.customer_id = t_sale.customer_id', 'left')
            ->join('user', 'user.user_id = t_sale.user_id', 'left')
            ->where('t_sale.sale_id', $saleId)
            ->first();

        if (!$sale) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Transaksi tidak ditemukan.');
        }

        $details = $this->saleDetailModel
            ->select('t_sale_detail.*, p_item.name AS item_name, p_item.barcode')
            ->join('p_item', 'p_item.item_id = t_sale_detail.item_id')
            ->where('sale_id', $saleId)
            ->findAll();

        // 4. Ambil data pengaturan toko dan kirim ke view
        $setting = $this->settingModel->getSetting();

        return view('pos/receipt', [
            'sale'    => $sale,
            'details' => $details,
            'setting' => $setting, // Variabel setting untuk nama toko & footer struk
        ]);
    }

    public function history()
    {
        $customers = $this->customerModel->orderBy('name', 'ASC')->findAll();

        $data = [
            'title'     => 'Riwayat Penjualan',
            'customers' => $customers,
            'cart'      => [],
            'subtotal'  => 0,
        ];

        return view('pos/history', $data);
    }

    public function historyAjax()
    {
        $request  = $this->request;
        $page     = max(1, (int) ($request->getGet('page') ?? 1));
        $perPage  = 15;
        $invoice  = trim($request->getGet('invoice') ?? '');
        $dateFrom = $request->getGet('date_from');
        $dateTo   = $request->getGet('date_to');

        $db      = db_connect();
        $builder = $db->table('t_sale s');

        $builder->select('
            s.sale_id, s.invoice, s.customer_id, s.total_price, s.discount, 
            s.final_price, s.cash, s.uang_kembalian, s.note, s.date, s.created, 
            c.name AS customer_name, u.name AS cashier_name
        ');
        
        $builder->join('customer c', 'c.customer_id = s.customer_id', 'left');
        $builder->join('user u', 'u.user_id = s.user_id', 'left');

        if ($invoice !== '') {
            $builder->like('s.invoice', $invoice);
        }
        if (!empty($dateFrom)) {
            $builder->where('s.date >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $builder->where('s.date <=', $dateTo);
        }

        $builder->orderBy('s.sale_id', 'DESC');
        $sales = $builder->get($perPage, ($page - 1) * $perPage)->getResultArray();

        $countBuilder = $db->table('t_sale s');

        if ($invoice !== '') {
            $countBuilder->like('s.invoice', $invoice);
        }
        if (!empty($dateFrom)) {
            $countBuilder->where('s.date >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $countBuilder->where('s.date <=', $dateTo);
        }

        $total      = $countBuilder->countAllResults();
        $totalPages = max(1, (int) ceil($total / $perPage));

        return $this->response->setJSON([
            'success'    => true,
            'data'       => $sales,
            'pagination' => [
                'page'        => $page,
                'per_page'    => $perPage,
                'total'       => $total,
                'total_pages' => $totalPages,
            ],
        ]);
    }

    public function saleDetailAjax($saleId)
    {
        $db = db_connect();

        $sale = $db->table('t_sale s')
            ->select('s.*, c.name AS customer_name, u.name AS cashier_name')
            ->join('customer c', 'c.customer_id = s.customer_id', 'left')
            ->join('user u', 'u.user_id = s.user_id', 'left')
            ->where('s.sale_id', $saleId)
            ->get()
            ->getRowArray();

        if (!$sale) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ]);
        }

        $details = $db->table('t_sale_detail d')
            ->select('d.*, p.name AS item_name, p.barcode')
            ->join('p_item p', 'p.item_id = d.item_id')
            ->where('d.sale_id', $saleId)
            ->orderBy('d.id_detail', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'sale'    => $sale,
            'details' => $details,
        ]);
    }

    public function searchProducts()
    {
        $keyword = $this->request->getGet('q');
        
        $products = $this->productModel
                     ->like('name', $keyword)
                     ->orLike('barcode', $keyword)
                     ->where('stock >', 0)
                     ->limit(10)
                     ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data'    => $products
        ]);
    }

    public function exportPdf()
    {
        $request  = $this->request;
        $invoice  = trim($request->getGet('invoice') ?? '');
        $dateFrom = $request->getGet('date_from');
        $dateTo   = $request->getGet('date_to');

        $db      = db_connect();
        $builder = $db->table('t_sale s');

        $builder->select('
            s.sale_id, s.invoice, s.customer_id, s.total_price, s.discount, 
            s.final_price, s.cash, s.uang_kembalian, s.note, s.date, s.created, 
            c.name AS customer_name, u.name AS cashier_name
        ');
        
        $builder->join('customer c', 'c.customer_id = s.customer_id', 'left');
        $builder->join('user u', 'u.user_id = s.user_id', 'left');

        if ($invoice !== '') {
            $builder->like('s.invoice', $invoice);
        }
        if (!empty($dateFrom)) {
            $builder->where('s.date >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $builder->where('s.date <=', $dateTo);
        }

        $builder->orderBy('s.sale_id', 'DESC');
        $sales = $builder->get()->getResultArray();

        $setting = $this->settingModel->getSetting();

        $data = [
            'sales'    => $sales,
            'setting'  => $setting,
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,
        ];

        $html = view('pos/report_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Mengirimkan hasil render PDF melalui Response CodeIgniter
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }
}