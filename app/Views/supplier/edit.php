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
                    <h1 class="m-0 fw-bold">Edit Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('supplier') ?>">Supplier</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- PAGE SUBTITLE -->
            <div class="mb-4">
                <p class="text-muted mb-0">
                    Perbarui data supplier
                </p>
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

            <!-- FORM CARD -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="<?= base_url('supplier/update/' . $supplier['supplier_id']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    Nama Supplier <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       value="<?= old('name', $supplier['name']) ?>" 
                                       maxlength="100" 
                                       required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    No. HP <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       class="form-control" 
                                       value="<?= old('phone', $supplier['phone']) ?>" 
                                       maxlength="16" 
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Alamat <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="address" 
                                       class="form-control" 
                                       value="<?= old('address', $supplier['address']) ?>" 
                                       maxlength="100" 
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Keterangan
                                </label>
                                <textarea name="desc" 
                                          class="form-control" 
                                          rows="4"><?= old('desc', $supplier['desc']) ?></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-save me-1"></i> Update
                                    </button>
                                    <a href="<?= base_url('supplier') ?>" class="btn btn-outline-secondary">
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