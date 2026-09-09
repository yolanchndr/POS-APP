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
                    <h1 class="m-0 fw-bold">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- <div class="container-fluid"> -->

            <!-- STATISTICS CARDS -->
            <div class="row g-3 mb-4">
                
                <!-- PRODUK -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Produk</small>
                                    <h3 class="fw-bold mb-0">
                                        <?= number_format($totalProduk, 0, ',', '.') ?>
                                    </h3>
                                </div>
                                <div class="fs-2 text-primary">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="<?= base_url('item') ?>" class="small text-decoration-none">
                                    Kelola produk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CUSTOMER -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Customer</small>
                                    <h3 class="fw-bold mb-0">
                                        <?= number_format($totalCustomer, 0, ',', '.') ?>
                                    </h3>
                                </div>
                                <div class="fs-2 text-success">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="<?= base_url('customer') ?>" class="small text-decoration-none">
                                    Kelola customer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STOK MENIPIS -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Stok Menipis</small>
                                    <h3 class="fw-bold mb-0">
                                        <?= number_format($stokMenipis, 0, ',', '.') ?>
                                    </h3>
                                </div>
                                <div class="fs-2 text-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="<?= base_url('item?stok=menipis') ?>" class="small text-decoration-none text-warning">
                                    Lihat stok menipis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STOK HABIS -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Stok Habis</small>
                                    <h3 class="fw-bold mb-0">
                                        <?= number_format($stokHabis, 0, ',', '.') ?>
                                    </h3>
                                </div>
                                <div class="fs-2 text-danger">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="<?= base_url('item?stok=habis') ?>" class="small text-decoration-none text-danger">
                                    Lihat stok habis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SALES / KASIR BANNER -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Penjualan Hari Ini</small>
                                    <h2 class="fw-bold mb-1">
                                        Rp <?= number_format($penjualanHariIni, 0, ',', '.') ?>
                                    </h2>
                                    <span class="text-muted">
                                        <?= number_format($transaksiHariIni, 0, ',', '.') ?> transaksi
                                    </span>
                                </div>
                                <div class="fs-1 text-success">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <a href="<?= base_url('pos') ?>" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 bg-dark text-white">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <small>Transaksi</small>
                                    <h3 class="fw-bold mb-0">Buka Kasir</h3>
                                </div>
                                <i class="bi bi-cart3 fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- BOTTOM TABLES -->
            <div class="row g-3 mb-4">
                
                <!-- STOK MENIPIS TABLE -->
                <div class="col-12 col-xl-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                                    Stok Menipis
                                </strong>
                                <a href="<?= base_url('item?stok=menipis') ?>" class="small text-decoration-none">Lihat semua</a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($barangStokMenipis)) : ?>
                                            <?php foreach ($barangStokMenipis as $item) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold">
                                                            <?= esc($item['name']) ?>
                                                        </div>
                                                        <?php if (!empty($item['barcode'])) : ?>
                                                            <small class="text-muted">
                                                                <?= esc($item['barcode']) ?>
                                                            </small>
                                                        <?php else : ?>
                                                            <small class="text-muted">
                                                                Tanpa barcode
                                                            </small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($item['stock'] <= 2) : ?>
                                                            <span class="badge text-bg-danger">
                                                                <?= $item['stock'] ?>
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="badge text-bg-warning">
                                                                <?= $item['stock'] ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <?php if (is_admin()): ?>
                                                            <a href="<?= base_url('item/edit/' . $item['item_id']) ?>"
                                                               class="btn btn-sm btn-outline-primary"
                                                               title="Edit produk">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    <i class="bi bi-check-circle fs-3 d-block mb-2"></i>
                                                    Semua stok aman.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PENJUALAN TERBARU TABLE -->
                <div class="col-12 col-xl-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    <i class="bi bi-receipt me-1"></i>
                                    Penjualan Terbaru
                                </strong>
                                <a href="<?= base_url('pos/history') ?>" class="small text-decoration-none">
                                    Lihat semua
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($penjualanTerbaru)) : ?>
                                            <?php foreach ($penjualanTerbaru as $sale) : ?>
                                                <tr>
                                                    <td>
                                                        <span class="fw-semibold">
                                                            <?= esc($sale['invoice']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= esc($sale['customer_name'] ?? 'Umum') ?>
                                                    </td>
                                                    <td>
                                                        Rp <?= number_format($sale['final_price'], 0, ',', '.') ?>
                                                    </td>
                                                    <td>
                                                        <?= esc($sale['user_name'] ?? '-') ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="bi bi-receipt fs-3 d-block mb-2"></i>
                                                    Belum ada transaksi.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        

        <!-- </div> -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->include('layouts/footer') ?>