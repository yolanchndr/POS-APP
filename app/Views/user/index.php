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
                    <h1 class="m-0 fw-bold">User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                        Kelola pengguna dan hak akses sistem
                    </p>
                </div>

                <a href="<?= base_url('user/create') ?>" class="btn btn-dark">
                    <i class="bi bi-person-plus me-1"></i> Tambah User
                </a>
            </div>

            <!-- FLASHMESSAGES -->
            <?php if ($msg = session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= esc($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($msg = session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- SEARCH FILTER CARD -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form method="get" action="<?= base_url('user') ?>">
                        <div class="row g-2">
                            <div class="col-12 col-md-10">
                                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari username atau nama...">
                            </div>
                            <div class="col-6 col-md-1">
                                <button type="submit" class="btn btn-dark w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="col-6 col-md-1">
                                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary w-100">
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
                                    <th width="70">#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Alamat</th>
                                    <th width="120">Level</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada user.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    $page = isset($pager) ? $pager->getCurrentPage() : 1;
                                    $no = 1 + (($page - 1) * 10);
                                    ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <span class="fw-semibold"><?= esc($user['name']) ?></span>
                                            </td>
                                            <td>
                                                <code><?= esc($user['username']) ?></code>
                                            </td>
                                            <td>
                                                <?= esc($user['address'] ?: '-') ?>
                                            </td>
                                            <td>
                                                <?php if ($user['level'] === '1'): ?>
                                                    <span class="badge text-bg-primary">Admin</span>
                                                <?php else: ?>
                                                    <span class="badge text-bg-secondary">Kasir</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?= base_url('user/edit/' . $user['user_id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <?php if ((int) session()->get('user_id') !== (int) $user['user_id']): ?>
                                                        <a href="<?= base_url('user/delete/' . $user['user_id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
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