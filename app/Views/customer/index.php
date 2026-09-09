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
                    <h1 class="m-0 fw-bold">Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
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
                        Kelola data pelanggan
                    </p>
                </div>

                <a href="<?= base_url('customer/create') ?>" class="btn btn-dark">
                    <i class="bi bi-person-plus me-1"></i> Tambah Customer
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
                    <form method="get" action="<?= base_url('customer') ?>">
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
                                <a href="<?= base_url('customer') ?>" class="btn btn-outline-secondary w-100">
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
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                     <?php if (is_admin()): ?>
                                    <th width="130" class="text-center">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($customers)) : ?>
                                <?php
                                $no = 1 + (($pager->getCurrentPage() - 1) * 10);
                                ?>
                                <?php foreach ($customers as $customer) : ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= esc($customer['name']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($customer['gender'] === 'L') : ?>
                                                <span class="badge text-bg-primary">
                                                    Laki-laki
                                                </span>
                                            <?php else : ?>
                                                <span class="badge text-bg-secondary">
                                                    Perempuan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= esc($customer['phone']) ?>
                                        </td>
                                        <td>
                                            <?= esc($customer['address']) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('customer/edit/' . $customer['customer_id']) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                 <?php if (is_admin()): ?>
                                                <a href="<?= base_url('customer/delete/' . $customer['customer_id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus customer ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        Belum ada data customer.
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