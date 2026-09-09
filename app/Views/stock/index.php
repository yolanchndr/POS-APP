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
                    <h1 class="m-0 fw-bold">Stok</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Stok</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- HEADER & ACTION BUTTONS -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                <div>
                    <p class="text-muted mb-0">Riwayat pergerakan stok barang</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('stock/masuk') ?>" class="btn btn-dark">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Stok Masuk
                    </a>
                    <a href="<?= base_url('stock/keluar') ?>" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-up me-1"></i> Stok Keluar
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

            <!-- FILTER / SEARCH -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form method="get">
                        <div class="row g-2">
                            <div class="col-12 col-md-10">
                                <input type="text" name="keyword" value="<?= esc($keyword) ?>" class="form-control" placeholder="Cari barang, barcode, supplier...">
                            </div>
                            <div class="col-6 col-md-1">
                                <button class="btn btn-dark w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="col-6 col-md-1">
                                <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLE CONTENT -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Tipe</th>
                                    <th>Supplier</th>
                                    <th>Qty</th>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($stocks)) : ?>
                                <?php
                                $no = 1 + (($pager->getCurrentPage() - 1) * 15);
                                ?>
                                <?php foreach ($stocks as $stock) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <div class="fw-semibold">
                                                <?= esc($stock['item_name']) ?>
                                            </div>
                                            <small class="text-muted">
                                                <?= esc($stock['barcode']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if ($stock['type'] === 'in') : ?>
                                                <span class="badge text-bg-success">
                                                    <i class="bi bi-arrow-down me-1"></i> Masuk
                                                </span>
                                            <?php else : ?>
                                                <span class="badge text-bg-danger">
                                                    <i class="bi bi-arrow-up me-1"></i> Keluar
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= esc($stock['supplier_name'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <strong>
                                                <?= number_format($stock['qty'], 0, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($stock['date'])) ?>
                                        </td>
                                        <td>
                                            <?= esc($stock['user_name'] ?? '-') ?>
                                        </td>
                                         <td>
                                            <?= esc($stock['detail'] ?? '-') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                        Belum ada transaksi stok.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($pager->getPageCount() > 1) : ?>
                        <div class="mt-3">
                            <?= $pager->links() ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?= $this->include('layouts/footer') ?>