<?= $this->include('layouts/header') ?>

<!-- Load Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<!-- Navbar -->
<?= $this->include('layouts/navbar') ?>

<!-- Main Sidebar Container -->
<?= $this->include('layouts/sidebar') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold">Kasir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kasir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- HEADER & ACTION -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div>
                    <p class="text-muted mb-0">Transaksi penjualan</p>
                </div>
                <div>
                    <a href="<?= base_url('pos/clear-cart') ?>" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Kosongkan
                    </a>
                </div>
            </div>

            <!-- ALERT -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-3 mb-4">
                <!-- LEFT -->
                <div class="col-12 col-xl-8">
                    <!-- ADD PRODUCT -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <label class="form-label fw-semibold">Scan Barcode / Cari Produk</label>
                            
                            <!-- Cari Produk Manual Berdasarkan Nama (Tom Select) -->
                            <div class="mb-3">
                                <select id="selectProductSearch" class="form-select" placeholder="Ketik nama atau pilih produk..."></select>
                            </div>

                            <div class="position-relative d-flex align-items-center mb-3">
                                <hr class="w-100 border-secondary opacity-25">
                                <span class="px-2 bg-white text-muted small position-absolute start-50 translate-middle-x">ATAU SCAN BARCODE</span>
                            </div>

                            <!-- Search Input Barcode -->
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                <input type="text" id="barcodeInput" class="form-control form-control-lg" placeholder="Scan atau ketik barcode lalu tekan Enter..." autocomplete="off" autofocus>
                                <button type="button" class="btn btn-dark" id="btnSearchBarcode">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                            <div id="barcodeMessage" class="small mb-3"></div>

                            <!-- Form Manual Add to Cart -->
                            <form id="addCartForm">
                                <input type="hidden" name="item_id" id="selectedItemId">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-8">
                                        <div id="selectedProduct" class="border rounded p-3 bg-light h-100 d-flex align-items-center">
                                            <span class="text-muted">Belum ada produk dipilih</span>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-2">
                                        <label class="form-label text-muted small mb-1">Qty</label>
                                        <input type="number" id="productQty" class="form-control" value="1" min="1">
                                    </div>
                                    <div class="col-4 col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100 h-100" id="btnAddCart" disabled>
                                            <i class="bi bi-plus-lg me-1"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CART -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pt-3">
                            <strong class="fs-5">Keranjang</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center" style="width: 180px;">Qty</th>
                                            <th class="text-center" style="width: 120px;">Diskon</th>
                                            <th class="text-end">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTableBody">
                                        <?php if (!empty($cart)) : ?>
                                            <?php foreach ($cart as $item) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold"><?= esc($item['item_name']) ?></div>
                                                        <small class="text-muted"><?= esc($item['barcode']) ?></small>
                                                    </td>
                                                    <td class="text-center">
                                                        Rp <?= number_format($item['price'], 0, ',', '.') ?>
                                                    </td>
                                                    <td style="width: 180px;">
                                                        <div class="input-group input-group-sm">
                                                            <button type="button" class="btn btn-outline-secondary btn-qty-minus px-2" data-id="<?= $item['cart_id'] ?>">−</button>
                                                            <input type="number" class="form-control text-center cart-qty px-1" value="<?= $item['qty'] ?>" min="1" max="<?= $item['stock'] ?>" data-id="<?= $item['cart_id'] ?>">
                                                            <button type="button" class="btn btn-outline-secondary btn-qty-plus px-2" data-id="<?= $item['cart_id'] ?>">+</button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm cart-discount" value="<?= $item['discount_item'] ?>" min="0" data-id="<?= $item['cart_id'] ?>">
                                                    </td>
                                                    <td class="text-end fw-semibold">
                                                        Rp <?= number_format($item['total'], 0, ',', '.') ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-cart" data-id="<?= $item['cart_id'] ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">
                                                    <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                                    Keranjang masih kosong.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-12 col-xl-4">
                    <div class="card border-0 shadow-sm sticky-xl-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Pembayaran</h5>
                            <form method="post" action="<?= base_url('pos/checkout') ?>" id="checkoutForm">
                                <?= csrf_field() ?>

                                <!-- CUSTOMER (TOM SELECT) -->
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Customer</label>
                                    <select name="customer_id" id="select-customer" class="form-select" placeholder="Cari atau pilih customer...">
                                        <option value="">Umum</option>
                                        <?php foreach ($customers as $customer) : ?>
                                            <option value="<?= $customer['customer_id'] ?>">
                                                <?= esc($customer['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- SUBTOTAL -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <strong id="subtotalValue" class="fs-5">
                                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                    </strong>
                                </div>

                                <!-- DISCOUNT -->
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Diskon Transaksi (Rp)</label>
                                    <input type="number" name="discount" id="discount" class="form-control" value="0" min="0">
                                </div>

                                <!-- TOTAL -->
                                <div class="bg-light rounded p-3 mb-3 border">
                                    <small class="text-muted fw-semibold d-block">Total Bayar</small>
                                    <div class="fs-2 fw-bold text-dark" id="finalTotal">
                                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                    </div>
                                </div>

                                <!-- CASH -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Uang Dibayar</label>
                                    <input type="number" name="cash" id="cash" class="form-control form-control-lg fw-bold text-success" min="0" value="0" required>
                                </div>

                                <!-- CHANGE -->
                                <div class="d-flex justify-content-between align-items-center mb-4 p-2 border-bottom">
                                    <span class="text-muted fw-semibold">Kembalian</span>
                                    <strong id="change" class="fs-4 text-success">Rp 0</strong>
                                </div>

                                <!-- NOTE -->
                                <div class="mb-4">
                                    <label class="form-label text-muted small">Catatan (Opsional)</label>
                                    <textarea name="note" class="form-control" rows="2" placeholder="Catatan transaksi..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm" id="btnCheckout" <?= empty($cart) ? 'disabled' : '' ?>>
                                    <i class="bi bi-cash-stack me-2"></i> Proses Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- SUCCESS MODAL -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-check-lg text-success" style="font-size: 42px;"></i>
                    </div>
                </div>
                <h4 class="fw-bold">Transaksi Berhasil</h4>
                <p class="text-muted mb-1">Invoice</p>
                <h5 id="successInvoice" class="fw-bold">-</h5>

                <div class="bg-light rounded p-3 mt-3 mb-3 text-start">
                    <div class="d-flex justify-content-between">
                        <span>Total</span>
                        <strong id="successTotal">Rp 0</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Uang</span>
                        <strong id="successCash">Rp 0</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Kembalian</span>
                        <strong id="successChange" class="text-success">Rp 0</strong>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" id="btnPrintReceipt" class="btn btn-dark">
                        <i class="bi bi-printer me-1"></i> Cetak Struk
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="btnNewTransaction">
                        Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Tom Select JS -->
<script src="<?= base_url('assets/plugins/tom-select/tom-select.complete.min.js') ?>"></script>

<script>
// --- INISIALISASI TOM SELECT UNTUK CUSTOMER & PENCARIAN PRODUK ---
document.addEventListener('DOMContentLoaded', function () {
    // Tom Select Customer
    new TomSelect("#select-customer", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    // Tom Select Pencarian Produk Berdasarkan Nama / Barcode
    new TomSelect("#selectProductSearch", {
        valueField: 'item_id',
        labelField: 'name',
        searchField: ['name', 'barcode'],
        placeholder: 'Ketik nama atau scan barcode produk...',
        load: function(query, callback) {
            if (query.length < 2) return callback();
            
            fetch('<?= base_url('pos/search-products') ?>?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(result => {
                    callback(result.data || []);
                }).catch(() => {
                    callback();
                });
        },
        render: {
            option: function(item, escape) {
                return `<div class="py-2 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">${escape(item.name)}</div>
                        <small class="text-muted"><i class="bi bi-upc me-1"></i>${escape(item.barcode)} | Stok: ${item.stock}</small>
                    </div>
                    <div class="fw-bold text-primary">${rupiah(item.price)}</div>
                </div>`;
            },
            item: function(item, escape) {
                return `<div>${escape(item.name)} - ${rupiah(item.price)}</div>`;
            }
        },
        onChange: function(value) {
            if (!value) return;
            
            const item = this.options[value];
            if (item) {
                selectProductToForm(item);
            }
            this.clear();
        }
    });
});

// --- HELPER UNTUK MENGISI FORM PREVIEW DARI TOM SELECT ---
function selectProductToForm(product) {
    const selectedItemId = document.getElementById('selectedItemId');
    const selectedProduct = document.getElementById('selectedProduct');
    const productQty = document.getElementById('productQty');
    const btnAddCart = document.getElementById('btnAddCart');
    const message = document.getElementById('barcodeMessage');

    if (selectedItemId) selectedItemId.value = product.item_id;
    if (selectedProduct) {
        selectedProduct.innerHTML = `
            <div class="w-100 d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold text-dark">${product.name}</div>
                    <small class="text-muted"><i class="bi bi-upc me-1"></i>${product.barcode}</small>
                </div>
                <div class="text-end">
                    <div class="fw-bold text-primary">${rupiah(product.price)}</div>
                    <small class="text-muted">Stok: ${product.stock}</small>
                </div>
            </div>
        `;
    }
    if (productQty) {
        productQty.max = product.stock;
        productQty.value = 1;
        productQty.focus();
    }
    if (btnAddCart) btnAddCart.disabled = false;
    if (message) message.innerHTML = `<span class="text-success"><i class="bi bi-check-circle me-1"></i>Produk dipilih.</span>`;
}

// --- UTILITY FORMAT RUPIAH ---
function rupiah(value) {
    return 'Rp ' + Number(value).toLocaleString('id-ID');
}

// --- LOGIKA PEMBAYARAN & KALKULASI ---
function getSubtotal() {
    const element = document.getElementById('subtotalValue');
    if (!element) return 0;
    const text = element.textContent.replace(/[^\d]/g, '');
    return parseInt(text) || 0;
}

function calculate() {
    const discountInput = document.getElementById('discount');
    const cashInput = document.getElementById('cash');
    const finalTotalElement = document.getElementById('finalTotal');
    const changeElement = document.getElementById('change');

    let currentSubtotal = getSubtotal(); 
    let discountValue = discountInput ? (parseInt(discountInput.value) || 0) : 0;
    
    let cashValue = 0;
    if (cashInput) {
        let rawCash = cashInput.value.replace(/[^\d]/g, '');
        cashValue = rawCash === '' ? 0 : parseInt(rawCash);
    }

    let total = currentSubtotal - discountValue;
    if (total < 0) total = 0;

    let changeValue = cashValue - total;
    if (changeValue < 0) changeValue = 0;

    if (finalTotalElement) finalTotalElement.textContent = rupiah(total);
    if (changeElement) changeElement.textContent = rupiah(changeValue);
}

document.addEventListener('DOMContentLoaded', function () {
    const discount = document.getElementById('discount');
    const cash = document.getElementById('cash');

    if (discount) discount.addEventListener('input', calculate);
    
    if (cash) {
        cash.addEventListener('focus', function() {
            if (this.value === '0') {
                this.value = '';
            }
        });

        cash.addEventListener('blur', function() {
            if (this.value === '') {
                this.value = '0';
            }
        });

        cash.addEventListener('input', calculate);
    }
    
    calculate(); 
});


// --- LOGIKA BARCODE & TAMBAH KE KERANJANG ---
document.addEventListener('DOMContentLoaded', function () {
    const barcodeInput = document.getElementById('barcodeInput');
    const searchButton = document.getElementById('btnSearchBarcode');
    const selectedItemId = document.getElementById('selectedItemId');
    const selectedProduct = document.getElementById('selectedProduct');
    const productQty = document.getElementById('productQty');
    const btnAddCart = document.getElementById('btnAddCart');
    const message = document.getElementById('barcodeMessage');
    const addCartForm = document.getElementById('addCartForm');

    function resetProduct() {
        if (selectedItemId) selectedItemId.value = '';
        if (selectedProduct) {
            selectedProduct.innerHTML = `<span class="text-muted">Belum ada produk dipilih</span>`;
        }
        if (productQty) productQty.value = 1;
        if (btnAddCart) btnAddCart.disabled = true;
    }

    async function searchBarcode(autoAdd = false) {
        if (!barcodeInput) return;
        const barcode = barcodeInput.value.trim();
        if (!barcode) return;

        message.innerHTML = `<span class="text-muted"><i class="bi bi-hourglass-split me-1"></i>Mencari...</span>`;

        try {
            const response = await fetch(`<?= base_url('pos/barcode') ?>?barcode=${encodeURIComponent(barcode)}`);
            const result = await response.json();

            if (!result.success) {
                resetProduct();
                message.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle me-1"></i>${result.message}</span>`;
                barcodeInput.select();
                return;
            }

            const product = result.data;
            selectedItemId.value = product.item_id;
            selectedProduct.innerHTML = `
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark">${product.name}</div>
                        <small class="text-muted"><i class="bi bi-upc me-1"></i>${product.barcode}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-primary">${rupiah(product.price)}</div>
                        <small class="text-muted">Stok: ${product.stock}</small>
                    </div>
                </div>
            `;
            productQty.max = product.stock;
            btnAddCart.disabled = false;
            message.innerHTML = `<span class="text-success"><i class="bi bi-check-circle me-1"></i>Produk ditemukan.</span>`;

            if (autoAdd) {
                const added = await addProductToCart(product.item_id, 1);
                if (added) {
                    await refreshCart();
                    barcodeInput.value = '';
                    resetProduct();
                    barcodeInput.focus();
                }
            } else {
                productQty.focus();
            }
        } catch (error) {
            resetProduct();
            message.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Terjadi kesalahan sistem.</span>`;
            console.error(error);
        }
    }

    if (searchButton) {
        searchButton.addEventListener('click', () => searchBarcode(false)); 
    }

    if (barcodeInput) {
        barcodeInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchBarcode(true); 
            }
        });
    }

    if (addCartForm) {
        addCartForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const itemId = selectedItemId.value;
            const qty = productQty.value || 1;

            if (!itemId) return;

            const added = await addProductToCart(itemId, qty);
            if (added) {
                await refreshCart();
                barcodeInput.value = '';
                resetProduct();
                barcodeInput.focus();
            }
        });
    }
});


// --- AJAX FUNGSI KERANJANG ---
async function addProductToCart(itemId, qty = 1) {
    const formData = new FormData();
    formData.append('item_id', itemId);
    formData.append('qty', qty);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
    
    const msgElement = document.getElementById('barcodeMessage');

    try {
        const response = await fetch('<?= base_url('pos/add-cart-ajax') ?>', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (!result.success) {
            if (msgElement) msgElement.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle me-1"></i>${result.message}</span>`;
            return false;
        }

        if (msgElement) msgElement.innerHTML = `<span class="text-success"><i class="bi bi-check-circle me-1"></i>${result.message}</span>`;
        return true;
    } catch (error) {
        console.error(error);
        if (msgElement) msgElement.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Gagal menambah produk.</span>`;
        return false;
    }
}

async function refreshCart() {
    try {
        const response = await fetch('<?= base_url('pos/cart-ajax') ?>');
        const result = await response.json();

        if (!result.success) return;

        renderCart(result.cart);
        updateSubtotalUI(result.subtotal);
        calculate(); 

        const btnCheckout = document.getElementById('btnCheckout');
        if (btnCheckout) {
            btnCheckout.disabled = result.cart.length === 0;
        }
    } catch (error) {
        console.error('Gagal mengambil cart:', error);
    }
}

function renderCart(cart) {
    const tbody = document.getElementById('cartTableBody');
    if (!cart.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                    Keranjang masih kosong.
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = cart.map(item => `
        <tr>
            <td>
                <div class="fw-semibold">${escapeHtml(item.item_name)}</div>
                <small class="text-muted">${escapeHtml(item.barcode ?? '')}</small>
            </td>
            <td class="text-center">${rupiah(item.price)}</td>
            <td style="width: 180px;">
                <div class="input-group input-group-sm">
                    <button type="button" class="btn btn-outline-secondary btn-qty-minus px-2" data-id="${item.cart_id}">−</button>
                    <input type="number" class="form-control text-center cart-qty px-1" value="${item.qty}" min="1" max="${item.stock}" data-id="${item.cart_id}">
                    <button type="button" class="btn btn-outline-secondary btn-qty-plus px-2" data-id="${item.cart_id}">+</button>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm cart-discount" value="${item.discount_item}" min="0" data-id="${item.cart_id}">
            </td>
            <td class="text-end fw-semibold">${rupiah(item.total)}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-cart" data-id="${item.cart_id}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function updateSubtotalUI(value) {
    const element = document.getElementById('subtotalValue');
    if (element) {
        element.textContent = rupiah(value);
    }
}

// --- EVENT LISTENER KONTROL KERANJANG ---
document.addEventListener('click', async function(event) {
    const plus = event.target.closest('.btn-qty-plus');
    const minus = event.target.closest('.btn-qty-minus');
    const deleteButton = event.target.closest('.btn-delete-cart');

    if (plus) {
        const cartId = plus.dataset.id;
        const input = document.querySelector(`.cart-qty[data-id="${cartId}"]`);
        if (!input) return;

        const max = parseInt(input.max);
        let qty = parseInt(input.value) || 1;

        if (qty < max) {
            qty++;
            await updateCart(cartId, qty);
        }
        return;
    }

    if (minus) {
        const cartId = minus.dataset.id;
        const input = document.querySelector(`.cart-qty[data-id="${cartId}"]`);
        if (!input) return;

        let qty = parseInt(input.value) || 1;
        if (qty > 1) {
            qty--;
            await updateCart(cartId, qty);
        }
        return;
    }

    if (deleteButton) {
        const cartId = deleteButton.dataset.id;
        await deleteCart(cartId);
    }
});

document.addEventListener('change', async function(event) {
    if (event.target.classList.contains('cart-discount')) {
        const cartId = event.target.dataset.id;
        const discount = parseInt(event.target.value) || 0;
        const qtyInput = document.querySelector(`.cart-qty[data-id="${cartId}"]`);
        const qty = parseInt(qtyInput?.value) || 1;
        
        await updateCart(cartId, qty, discount);
    }

    if (event.target.classList.contains('cart-qty')) {
        const cartId = event.target.dataset.id;
        let qty = parseInt(event.target.value) || 1;
        const max = parseInt(event.target.max);

        if (qty > max) qty = max;
        if (qty < 1) qty = 1;

        await updateCart(cartId, qty);
    }
});

async function updateCart(cartId, qty, discount = null) {
    const formData = new FormData();
    formData.append('cart_id', cartId);
    formData.append('qty', qty);

    if (discount === null) {
        const input = document.querySelector(`.cart-discount[data-id="${cartId}"]`);
        discount = parseInt(input?.value) || 0;
    }

    formData.append('discount_item', discount);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    try {
        const response = await fetch('<?= base_url('pos/update-cart-ajax') ?>', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (!result.success) {
            alert(result.message);
            return;
        }
        await refreshCart();
    } catch (error) {
        console.error(error);
        alert('Gagal memperbarui cart.');
    }
}

async function deleteCart(cartId) {
    if (!confirm('Hapus barang dari keranjang?')) return;

    const formData = new FormData();
    formData.append('cart_id', cartId);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    try {
        const response = await fetch('<?= base_url('pos/delete-cart-ajax') ?>', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (!result.success) {
            alert(result.message);
            return;
        }
        await refreshCart();
    } catch (error) {
        console.error(error);
        alert('Gagal menghapus barang.');
    }
}

// --- CHECKOUT & MODAL SUCCESS ---
document.getElementById('checkoutForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const form = this;
    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;

    button.disabled = true;
    button.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1"></span>
        Memproses...
    `;

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (!result.success) {
            alert(result.message);
            button.disabled = false;
            button.innerHTML = originalText;
            return;
        }

        document.getElementById('successInvoice').textContent = result.data.invoice;
        document.getElementById('successTotal').textContent = rupiah(result.data.final_price);
        document.getElementById('successCash').textContent = rupiah(result.data.cash);
        document.getElementById('successChange').textContent = rupiah(result.data.change);

        window.lastSaleId = result.data.sale_id;
        window.lastInvoice = result.data.invoice;

        $('#successModal').modal('show');

    } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat memproses transaksi.');
    } finally {
        button.disabled = false;
        button.innerHTML = originalText;
    }
});

document.getElementById('btnNewTransaction').addEventListener('click', function() {
    window.location.reload();
});

document.getElementById('btnPrintReceipt').addEventListener('click', function() {
    if (!window.lastSaleId) return;

    window.open('<?= base_url('pos/receipt') ?>/' + window.lastSaleId, '_blank');
});
</script>

<?= $this->include('layouts/footer') ?>