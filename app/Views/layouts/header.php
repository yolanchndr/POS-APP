<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212529">
    <title><?= esc($title ?? 'Lorem Ipsum') ?></title>

    <!-- Google Font: Source Sans Pro -->
 
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- AdminLTE Style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-icons/bootstrap-icons.min.css') ?>">
    <!-- CSS Tom Select -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/tom-select/tom-select.bootstrap5.min.css') ?>">
    

    <!-- CSS PERBAIKAN SCROLL & LAYOUT -->
    <style>
        html, body {
            height: auto !important;
            min-height: 100% !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }

        .wrapper {
            height: auto !important;
            min-height: 100vh !important;
            overflow: visible !important;
        }

        /* Navbar menempel di atas */
        .main-header, .navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1037;
        }

        /* Footer menempel di bawah */
        .main-footer, footer {
            position: fixed !important;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1036;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
        }

        /* Sidebar fixed dan bisa di-scroll jika menu panjang */
        .main-sidebar, aside {
            position: fixed !important;
            top: 56px; 
            bottom: 60px; 
            left: 0;
            overflow-y: auto; 
            z-index: 1035;
        }

        /* Mengatur ruang konten utama */
        .content-wrapper {
            margin-top: 56px;   
            margin-bottom: 60px; 
            margin-left: 250px;  
            overflow-y: auto;
            min-height: calc(100vh - 116px) !important;
        }

        /* Responsif untuk layar kecil / HP */
        @media (max-width: 991.98px) {
            .main-sidebar, aside {
                top: 0 !important;
                bottom: auto !important;
                height: 100vh !important;
                transform: translate3d(-250px, 0, 0);
                transition: transform 0.3s ease-in-out;
                z-index: 1045;
            }
            body.sidebar-open .main-sidebar, 
            body.sidebar-open aside {
                transform: translate3d(0, 0, 0) !important;
            }
            .content-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">