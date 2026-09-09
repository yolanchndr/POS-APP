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
                    <h1 class="m-0 fw-bold">Tambah User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('user') ?>">User</a></li>
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

            <!-- PAGE HEADER & ACTION BUTTON -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-muted mb-0">
                        Tambah pengguna baru ke dalam sistem
                    </p>
                </div>
                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- FLASHMESSAGES / ERRORS -->
            <?php if ($msg = session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($errors = session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="post" action="<?= base_url('user/store') ?>">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" value="<?= old('name') ?>" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="<?= old('username') ?>" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" minlength="6" required>
                                <div class="form-text">Minimal 6 karakter.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Level</label>
                                <select name="level" class="form-select" required>
                                    <option value="2" <?= old('level') === '2' ? 'selected' : '' ?>>Kasir</option>
                                    <option value="1" <?= old('level') === '1' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3"><?= old('address') ?></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary">
                                    Batal
                                </a>
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