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
                    <h1 class="m-0 fw-bold">Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- PAGE HEADER & ACTION BUTTON -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <p class="text-muted mb-0">
                        Kelola data produk dan stok
                    </p>
                </div>

                <a href="<?= base_url('item/create') ?>" class="btn btn-dark">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                </a>
            </div>

            <!-- FLASHMESSAGES -->
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

            <!-- SEARCH FILTER CARD -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form method="get" action="<?= base_url('item') ?>">
                        <div class="row g-2">
                            <div class="col-12 col-md-10">
                                <input type="text" 
                                       name="keyword" 
                                       class="form-control" 
                                       value="<?= esc($keyword ?? '') ?>" 
                                       placeholder="Cari barcode, nama produk, atau kategori...">
                            </div>
                            <div class="col-6 col-md-1">
                                <button type="submit" class="btn btn-dark w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="col-6 col-md-1">
                                <a href="<?= base_url('item') ?>" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DATA TABLE CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Barcode</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Min. Stok</th>
                                    <th class="text-center pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($items)) : ?>
                                <?php 
                                $no = 1 + (($pager->getCurrentPage() - 1) * 10);
                                ?>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <td class="ps-3"><?= $no++ ?></td>
                                        <td>
                                            <?php if ($item['barcode']) : ?>
                                                <code><?= esc($item['barcode']) ?></code>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= esc($item['name']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($item['category_name']) ?></td>
                                        <td><?= esc($item['unit_name']) ?></td>
                                        <td class="text-nowrap">Rp <?= number_format($item['price_a'], 0, ',', '.') ?></td>
                                        <td class="fw-semibold text-nowrap">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($item['stock'] <= 0) : ?>
                                                <span class="badge text-bg-danger">Habis</span>
                                            <?php elseif ($item['stock'] <= $item['min_stock']) : ?>
                                                <span class="badge text-bg-warning"><?= number_format($item['stock'], 0, ',', '.') ?></span>
                                            <?php else : ?>
                                                <span class="badge text-bg-success"><?= number_format($item['stock'], 0, ',', '.') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-light border"><?= number_format($item['min_stock'], 0, ',', '.') ?></span>
                                        </td>
                                        <td class="text-center pe-3">
                                            <div class="btn-group">
                                                <a href="<?= base_url('item/edit/' . $item['item_id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('item/delete/' . $item['item_id']) ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Hapus produk ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                            Produk tidak ditemukan.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($pager->getPageCount() > 1) : ?>
                    <div class="card-footer bg-white border-0">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?= $this->include('layouts/footer') ?>