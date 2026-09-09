<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212529">
    <title><?= esc($setting['store_name'] ? 'Login - ' . $setting['store_name'] : ($title ?? 'Login - HAYU FROZEN MART')) ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE Style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f5f6fa;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            max-width: 420px;
            width: 100%;
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="container">
    <div class="row justify-content-center align-items-center login-wrapper">
        <div class="col-12">
            <div class="card border-0 shadow-sm mx-auto login-card">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">
                            <?= esc($setting['store_name'] ?? 'HAYU FROZEN MART') ?>
                        </h4>
                        <p class="text-muted mb-0">
                            Silakan login untuk melanjutkan
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login/process') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       name="username" 
                                       class="form-control" 
                                       value="<?= old('username') ?>" 
                                       placeholder="Masukkan username" 
                                       autocomplete="username" 
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       placeholder="Masukkan password" 
                                       autocomplete="current-password" 
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & Bootstrap Bundle (JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>