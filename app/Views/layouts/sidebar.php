<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link text-center">
      <span class="brand-text font-weight-bold">
            <i></i> <?= esc($setting['store_name'] ?? 'LOREM IPSUM') ?>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Utama -->
                <li class="nav-header">UTAMA</li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() === 'dashboard' || uri_string() === '' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Transaksi -->
                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="<?= base_url('pos') ?>" class="nav-link <?= uri_string() === 'pos' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-cart3"></i>
                        <p>Kasir / POS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pos/history') ?>" class="nav-link <?= uri_string() === 'pos/history' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-receipt"></i>
                        <p>Penjualan</p>
                    </a>
                </li>

                <?php if (is_admin()): ?>
                <!-- Master Data -->
                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="<?= base_url('item') ?>" class="nav-link <?= uri_string() === 'item' || str_starts_with(uri_string(), 'item/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('category') ?>" class="nav-link <?= uri_string() === 'category' || str_starts_with(uri_string(), 'category/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('unit') ?>" class="nav-link <?= uri_string() === 'unit' || str_starts_with(uri_string(), 'unit/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-rulers"></i>
                        <p>Satuan</p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('customer') ?>" class="nav-link <?= uri_string() === 'customer' || str_starts_with(uri_string(), 'customer/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Customer</p>
                    </a>
                </li>
                <?php if (is_admin()): ?>
                <li class="nav-item">
                    <a href="<?= base_url('supplier') ?>" class="nav-link <?= uri_string() === 'supplier' || str_starts_with(uri_string(), 'supplier/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-truck"></i>
                        <p>Supplier</p>
                    </a>
                </li>

                <!-- Inventory -->
                <li class="nav-header">INVENTORY</li>
                <li class="nav-item">
                    <a href="<?= base_url('stock') ?>" class="nav-link <?= uri_string() === 'stock' || str_starts_with(uri_string(), 'stock/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-boxes"></i>
                        <p>Stok</p>
                    </a>
                </li>

                <!-- Pengaturan -->
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('user') ?>" class="nav-link <?= uri_string() === 'user' || str_starts_with(uri_string(), 'user/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>User Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('settings') ?>" class="nav-link <?= uri_string() === 'settings' || str_starts_with(uri_string(), 'settings/') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Pengaturan Toko</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>