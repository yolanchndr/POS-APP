<?= $this->include('layouts/header') ?>

<!-- Navbar -->
<?= $this->include('layouts/navbar') ?>

<!-- Main Sidebar Container -->
<?= $this->include('layouts/sidebar') ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold">Pengaturan Toko & Struk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="mb-4">
                <p class="text-muted mb-0">
                    Kelola informasi nama toko, alamat, kontak, dan catatan kaki pada struk thermal.
                </p>
            </div>

            <!-- FLASHMESSAGES -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- SETTINGS FORM CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="<?= base_url('settings/update') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="store_name" class="form-label fw-semibold">Nama Toko</label>
                            <input type="text" class="form-control" id="store_name" name="store_name" value="<?= esc($setting['store_name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="store_address" class="form-label fw-semibold">Alamat Toko</label>
                            <textarea class="form-control" id="store_address" name="store_address" rows="3" required><?= esc($setting['store_address']) ?></textarea>
                            <small class="text-muted">Gunakan tag HTML seperti &lt;br&gt; jika ingin membuat baris baru pada alamat.</small>
                        </div>

                        <div class="mb-3">
                            <label for="store_phone" class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" class="form-control" id="store_phone" name="store_phone" value="<?= esc($setting['store_phone']) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="receipt_footer" class="form-label fw-semibold">Teks Catatan Kaki Struk (Footer)</label>
                            <textarea class="form-control" id="receipt_footer" name="receipt_footer" rows="3" required><?= esc($setting['receipt_footer']) ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->include('layouts/footer') ?>