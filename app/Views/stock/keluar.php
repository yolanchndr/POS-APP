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
                    <h1 class="m-0 fw-bold">Stok Keluar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('stock') ?>">Stok</a></li>
                        <li class="breadcrumb-item active">Stok Keluar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ALERTS -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('stock/store-keluar') ?>">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <!-- FITUR SCAN / INPUT BARCODE CEPAT -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Scan / Ketik Barcode Cepat
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" id="barcodeScan" class="form-control" placeholder="Arahkan scanner ke barcode lalu tekan Enter atau scan..." autocomplete="off">
                                </div>
                                <div class="form-text">Scanner akan otomatis memilih produk jika barcode cocok.</div>
                            </div>

                            <div class="col-12">
                                <hr class="my-2">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Barang <span class="text-danger">*</span>
                                </label>
                                <select name="item_id" id="item_id" class="form-select" placeholder="Cari nama barang atau barcode..." required>
                                    <option value="">Pilih barang</option>
                                    <?php foreach ($products as $product) : ?>
                                        <option value="<?= $product['item_id'] ?>" data-barcode="<?= $product['barcode'] ?>" data-stock="<?= $product['stock'] ?>" <?= old('item_id') == $product['item_id'] ? 'selected' : '' ?>>
                                            <?= esc($product['name']) ?> - <?= esc($product['barcode']) ?> | Stok: <?= number_format($product['stock'], 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="stockInfo" class="form-text mt-1">
                                    Pilih barang untuk melihat stok.
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    Jumlah <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="qty" id="qty" class="form-control" min="1" value="<?= old('qty', 1) ?>" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="date" class="form-control" value="<?= old('date', date('Y-m-d')) ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Detail <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="detail" class="form-control" value="<?= old('detail') ?>" placeholder="Contoh: Barang rusak / pemakaian internal" maxlength="200" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea name="ket_stok" class="form-control" rows="3" placeholder="Keterangan tambahan"><?= old('ket_stok') ?></textarea>
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-box-arrow-up me-1"></i> Simpan Stok Keluar
                                    </button>
                                    <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?= $this->include('layouts/footer') ?>

<!-- Load Tom Select JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const qtyInput = document.getElementById('qty');
    const stockInfo = document.getElementById('stockInfo');

    // Inisialisasi Tom Select untuk dropdown barang
    const itemTomSelect = new TomSelect('#item_id', {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        onChange: function(value) {
            updateStockInfo(value);
        }
    });

    function updateStockInfo(selectedValue) {
        if (!selectedValue) {
            stockInfo.textContent = 'Pilih barang untuk melihat stok.';
            qtyInput.removeAttribute('max');
            return;
        }

        // Ambil elemen option asli berdasarkan value yang dipilih
        const option = document.querySelector(`#item_id option[value="${selectedValue}"]`);
        if (!option) return;

        const stock = parseInt(option.getAttribute('data-stock') || 0);
        stockInfo.innerHTML = 'Stok tersedia: <strong>' + stock.toLocaleString('id-ID') + '</strong>';
        qtyInput.max = stock;
    }

    // Tangani jika sudah terpilih sebelumnya (misalnya karena old() atau error validasi)
    if (itemTomSelect.getValue()) {
        updateStockInfo(itemTomSelect.getValue());
    }

    // Fitur Scan Barcode Cepat
    const barcodeInput = document.getElementById('barcodeScan');
    barcodeInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Mencegah form tersubmit otomatis
            let scannedCode = barcodeInput.value.trim();
            if (!scannedCode) return;

            let foundValue = '';
            let options = document.querySelectorAll('#item_id option');
            options.forEach(function (opt) {
                if (opt.getAttribute('data-barcode') === scannedCode) {
                    foundValue = opt.value;
                }
            });

            if (foundValue) {
                itemTomSelect.setValue(foundValue); // Otomatis memilih produk pada Tom Select
                barcodeInput.value = '';
                barcodeInput.placeholder = 'Berhasil dipilih! Scan lagi...';
                setTimeout(() => {
                    barcodeInput.placeholder = 'Arahkan scanner ke barcode lalu tekan Enter atau scan...';
                }, 2000);
            } else {
                alert('Barcode "' + scannedCode + '" tidak ditemukan!');
                barcodeInput.value = '';
            }
        }
    });
});
</script>