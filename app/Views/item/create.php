<?= $this->include('layouts/header') ?>

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
                    <h1 class="m-0 fw-bold">Tambah Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('item') ?>">Produk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="mb-4">
                <p class="text-muted mb-0">Tambahkan produk baru</p>
            </div>

            <!-- FLASHMESSAGES / ERRORS -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('item/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3 mb-4">

                    <!-- INFORMASI PRODUK -->
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Informasi Produk</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Barcode</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               name="barcode" 
                                               id="barcodeInput"
                                               class="form-control" 
                                               value="<?= old('barcode') ?>" 
                                               placeholder="Scan atau masukkan barcode">
                                        <button type="button" class="btn btn-outline-secondary" id="btnGenerateBarcode" title="Generate Barcode Otomatis">
                                            <i class="bi bi-magic me-1"></i> Generate
                                        </button>
                                    </div>
                                    <div class="form-text">Boleh dikosongkan atau klik Generate untuk membuat otomatis.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Produk <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control" 
                                           value="<?= old('name') ?>" 
                                           placeholder="Nama produk" 
                                           required>
                                </div>

                                <div class="row g-3">
                                    <!-- KATEGORI (MENGGUNAKAN TOM SELECT) -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">
                                            Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id" id="select-category" class="form-select" placeholder="Cari atau pilih kategori..." required>
                                            <option value="">Pilih Kategori</option>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?= $category['category_id'] ?>" <?= old('category_id') == $category['category_id'] ? 'selected' : '' ?>>
                                                    <?= esc($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- SATUAN (MENGGUNAKAN TOM SELECT) -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">
                                            Satuan <span class="text-danger">*</span>
                                        </label>
                                        <select name="unit_id" id="select-unit" class="form-select" placeholder="Cari atau pilih satuan..." required>
                                            <option value="">Pilih Satuan</option>
                                            <?php foreach ($units as $unit) : ?>
                                                <option value="<?= $unit['unit_id'] ?>" <?= old('unit_id') == $unit['unit_id'] ? 'selected' : '' ?>>
                                                    <?= esc($unit['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- HARGA & STOK -->
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Harga & Stok</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Harga Modal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" 
                                               name="price_a" 
                                               class="form-control currency-input" 
                                               value="<?= number_format(old('price_a', 0), 0, ',', '.') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Harga Jual <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" 
                                               name="price" 
                                               class="form-control currency-input" 
                                               value="<?= number_format(old('price', 0), 0, ',', '.') ?>" 
                                               required>
                                    </div>
                                </div>

                               <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Stok Awal <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        name="stock"
                                        id="stock"
                                        class="form-control"
                                        value="<?= old('stock', 0) ?>"
                                        min="0"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Minimum Stok <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           name="min_stock" 
                                           class="form-control" 
                                           value="<?= old('min_stock', 5) ?>" 
                                           min="0" 
                                           required>
                                    <div class="form-text text-muted small mt-1">
                                        Batas minimum stok untuk peringatan.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-1"></i> Simpan Produk
                            </button>
                            <a href="<?= base_url('item') ?>" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Load JS Tom Select -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Tom Select pada Kategori & Satuan
        new TomSelect("#select-category", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        new TomSelect("#select-unit", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        // Script Tombol Generate Barcode Otomatis
        const btnGenerate = document.getElementById('btnGenerateBarcode');
        const barcodeInput = document.getElementById('barcodeInput');

        if (btnGenerate && barcodeInput) {
            btnGenerate.addEventListener('click', function () {
                const now = new Date();
                const year = now.getFullYear().toString().slice(-2);
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const randomNum = Math.floor(1000 + Math.random() * 9000);
                
                const generatedCode = `BRC${year}${month}${day}${randomNum}`;
                barcodeInput.value = generatedCode;
                
                barcodeInput.classList.add('is-valid');
                setTimeout(() => {
                    barcodeInput.classList.remove('is-valid');
                }, 1500);
            });
        }
    });

    // Script otomatis format pemisah titik ribuan
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('currency-input')) {
            let input = e.target;
            let value = input.value.replace(/[^,\d]/g, '').toString();
            
            if (value === "") {
                input.value = "";
                return;
            }

            if (value.length > 1 && value.startsWith('0')) {
                value = value.replace(/^0+/, '');
            }

            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;
        }
    });

    document.getElementById('stock').addEventListener('input', function () {
        if (this.value.length > 1 && this.value.startsWith('0')) {
            this.value = this.value.replace(/^0+/, '');
        }
    });

    // Bersihkan format titik saat form disubmit
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelectorAll('.currency-input').forEach(function (input) {
            input.value = input.value.replace(/\./g, '');
        });
    });
</script>

<?= $this->include('layouts/footer') ?>