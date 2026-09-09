<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <!-- Tombol Toggle Sidebar (Desktop & Mobile) -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="bi bi-list fs-5"></i></a>
        </li>
        <!-- Brand / Title di Navbar -->
        <li class="nav-item d-none d-sm-inline-block align-self-center">
            <span class="navbar-brand fw-bold mb-0 ps-2"><?= esc($setting['store_name'] ?? 'LOREM IPSUM') ?></span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center">
        
        <!-- Indikator Jam Realtime (Tampil di semua ukuran layar dengan ukuran teks menyesuaikan) -->
        <li class="nav-item px-2 d-flex align-items-center text-secondary fw-medium small">
            <i class="bi bi-clock me-1"></i>
            <span id="realtime-clock">--:--:--</span>
        </li>

        <!-- User Info -->
        <li class="nav-item px-2 d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-5"></i>
            <span class="d-none d-md-inline fw-semibold"><?= esc(session()->get('name') ?? 'User') ?></span> 
            <small class="text-muted d-none d-lg-inline"> 
                (<?= session()->get('level') === '1' ? 'Administrator' : 'Kasir' ?>)
            </small>
        </li>
        
        <!-- Tombol Logout -->
        <li class="nav-item ms-2">
            <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>

</nav>
<!-- /.navbar -->

<!-- Skrip Jam Realtime -->
<script>
function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    const clockElement = document.getElementById('realtime-clock');
    if (clockElement) {
        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    }
}

// Jalankan saat halaman dimuat dan perbarui setiap 1 detik
document.addEventListener('DOMContentLoaded', function() {
    updateClock();
    setInterval(updateClock, 1000);
});
</script>