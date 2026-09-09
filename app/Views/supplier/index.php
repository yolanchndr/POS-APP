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
                    <h1 class="m-0 fw-bold">Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
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
                        Kelola data pemasok barang
                    </p>
                </div>

                <a href="<?= base_url('supplier/create') ?>" class="btn btn-dark">
                    <i class="bi bi-building-add me-1"></i> Tambah Supplier
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
                    <form method="get" action="<?= base_url('supplier') ?>">
                        <div class="row g-2">
                            <div class="col-12 col-md-10">
                                <input type="text" 
                                       name="keyword" 
                                       class="form-control" 
                                       value="<?= esc($keyword ?? '') ?>" 
                                       placeholder="Cari nama, nomor HP, atau alamat...">
                            </div>
                            <div class="col-6 col-md-1">
                                <button type="submit" class="btn btn-dark w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="col-6 col-md-1">
                                <a href="<?= base_url('supplier') ?>" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DATA TABLE CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th>Supplier</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Keterangan</th>
                                    <th width="130" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($suppliers)) : ?>
                                <?php
                                $no = 1 + (($pager->getCurrentPage() - 1) * 10);
                                ?>
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= esc($supplier['name']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= esc($supplier['phone']) ?>
                                        </td>
                                        <td>
                                            <?= esc($supplier['address']) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($supplier['desc'])) : ?>
                                                <?= esc($supplier['desc']) ?>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('supplier/edit/' . $supplier['supplier_id']) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('supplier/delete/' . $supplier['supplier_id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus supplier ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-building fs-1 d-block mb-2"></i>
                                        Belum ada data supplier.
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