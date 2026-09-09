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
                    <h1 class="m-0 fw-bold">Riwayat Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- HEADER & ACTION -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <div class="text-muted small">Daftar transaksi penjualan</div>
                </div>
                <a href="<?= base_url('pos') ?>" class="btn btn-primary">
                    <i class="bi bi-cart me-1"></i> Kasir
                </a>
            </div>

            <!-- FILTER -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label">Invoice</label>
                            <input type="text" id="filterInvoice" class="form-control" placeholder="Cari invoice...">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Dari</label>
                            <input type="date" id="filterDateFrom" class="form-control">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Sampai</label>
                            <input type="date" id="filterDateTo" class="form-control">
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-end gap-1">
                            <button type="button" id="btnFilter" class="btn btn-dark w-100">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <button type="button" id="btnExportPdf" class="btn btn-danger" title="Cetak PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Kasir</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center" style="width:120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="historyTable">
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="spinner-border spinner-border-sm me-2"></div>
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small id="historyInfo" class="text-muted"></small>
                        <nav>
                            <ul id="pagination" class="pagination pagination-sm mb-0"></ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- DETAIL MODAL -->
<div class="modal fade" id="saleDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="saleDetailContent">
                Memuat...
            </div>
        </div>
    </div>
</div>

<script>
let historyPage = 1;

function rupiah(value) {
    return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
}

async function loadHistory(page = 1) {
    historyPage = page;
    const params = new URLSearchParams();
    params.set('page', page);

    const invoice = document.getElementById('filterInvoice').value.trim();
    const dateFrom = document.getElementById('filterDateFrom').value;
    const dateTo = document.getElementById('filterDateTo').value;

    if (invoice) params.set('invoice', invoice);
    if (dateFrom) params.set('date_from', dateFrom);
    if (dateTo) params.set('date_to', dateTo);

    const tbody = document.getElementById('historyTable');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-5">
                <div class="spinner-border spinner-border-sm me-2"></div>
                Memuat data...
            </td>
        </tr>
    `;

    try {
        const response = await fetch('<?= base_url('pos/history-ajax') ?>?' + params.toString());
        const result = await response.json();

        if (!result.success) {
            throw new Error('Gagal mengambil data.');
        }

        renderHistory(result.data);
        renderPagination(result.pagination);
    } catch (error) {
        console.error(error);
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-5">
                    Gagal memuat data.
                </td>
            </tr>
        `;
    }
}

function renderHistory(data) {
    const tbody = document.getElementById('historyTable');

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-5">
                    <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                    Tidak ada transaksi.
                </td>
            </tr>
        `;
        document.getElementById('historyInfo').textContent = '';
        return;
    }

    tbody.innerHTML = data.map(function(row) {
        return `
            <tr>
                <td>
                    <div class="fw-semibold">${escapeHtml(row.invoice)}</div>
                </td>
                <td>${formatDate(row.created)}</td>
                <td>${escapeHtml(row.customer_name || 'Umum')}</td>
                <td>${escapeHtml(row.cashier_name || '-')}</td>
                <td class="text-end fw-semibold">${rupiah(row.final_price)}</td>
                <td>
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showDetail(${row.sale_id})">
                            <i class="bi bi-eye"></i>
                        </button>
                        <a href="<?= base_url('pos/receipt') ?>/${row.sale_id}" target="_blank" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-printer"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function renderPagination(pagination) {
    const element = document.getElementById('pagination');
    const page = pagination.page;
    const totalPages = pagination.total_pages;
    const total = pagination.total;

    if (total === 0) {
        element.innerHTML = '';
        return;
    }

    let html = '';
    html += `
        <li class="page-item ${page <= 1 ? 'disabled' : ''}">
            <button class="page-link" onclick="loadHistory(${page - 1})">‹</button>
        </li>
    `;

    const start = Math.max(1, page - 2);
    const end = Math.min(totalPages, page + 2);

    for (let i = start; i <= end; i++) {
        html += `
            <li class="page-item ${i === page ? 'active' : ''}">
                <button class="page-link" onclick="loadHistory(${i})">${i}</button>
            </li>
        `;
    }

    html += `
        <li class="page-item ${page >= totalPages ? 'disabled' : ''}">
            <button class="page-link" onclick="loadHistory(${page + 1})">›</button>
        </li>
    `;

    element.innerHTML = html;

    const startData = ((page - 1) * pagination.per_page) + 1;
    const endData = Math.min(page * pagination.per_page, total);

    document.getElementById('historyInfo').textContent = `Menampilkan ${startData}–${endData} dari ${total} transaksi`;
}

function formatDate(value) {
    if (!value) return '-';
    const date = new Date(value.replace(' ', 'T'));
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }) + ' ' + date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

async function showDetail(saleId) {
    const content = document.getElementById('saleDetailContent');
    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border"></div>
            <div class="mt-2">Memuat detail...</div>
        </div>
    `;

    const modalElement = document.getElementById('saleDetailModal');
    
    if (typeof jQuery !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('show');
    } else {
        modalElement.classList.add('show');
        modalElement.style.display = 'block';
        modalElement.removeAttribute('aria-hidden');
        modalElement.setAttribute('aria-modal', 'true');
        modalElement.setAttribute('role', 'dialog');
        
        if (!document.querySelector('.modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
        document.body.classList.add('modal-open');
    }

    try {
        const response = await fetch('<?= base_url('pos/sale-detail-ajax') ?>/' + saleId);
        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message);
        }

        const sale = result.sale;
        const details = result.details;

        content.innerHTML = `
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <small class="text-muted">Invoice</small>
                    <div class="fw-bold">${escapeHtml(sale.invoice)}</div>
                </div>
                <div class="col-6">
                    <small class="text-muted">Tanggal</small>
                    <div class="fw-bold">${formatDate(sale.created)}</div>
                </div>
                <div class="col-6">
                    <small class="text-muted">Customer</small>
                    <div>${escapeHtml(sale.customer_name || 'Umum')}</div>
                </div>
                <div class="col-6">
                    <small class="text-muted">Kasir</small>
                    <div>${escapeHtml(sale.cashier_name || '-')}</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${details.map(function(item) {
                            return `
                                <tr>
                                    <td>${escapeHtml(item.item_name)}</td>
                                    <td class="text-center">${item.qty}</td>
                                    <td class="text-end">${rupiah(item.price)}</td>
                                    <td class="text-end">${rupiah(item.total)}</td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
            </div>

            <div class="border-top pt-3">
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong>${rupiah(sale.total_price)}</strong>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span>Diskon</span>
                    <strong>${rupiah(sale.discount)}</strong>
                </div>
                <div class="d-flex justify-content-between mt-2 fs-5">
                    <strong>TOTAL</strong>
                    <strong>${rupiah(sale.final_price)}</strong>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span>Tunai</span>
                    <span>${rupiah(sale.cash)}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Kembalian</span>
                    <span>${rupiah(sale.uang_kembalian)}</span>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="<?= base_url('pos/receipt') ?>/${sale.sale_id}" target="_blank" class="btn btn-dark">
                    <i class="bi bi-printer me-1"></i> Cetak Struk
                </a>
            </div>
        `;
    } catch (error) {
        content.innerHTML = `
            <div class="alert alert-danger">
                ${escapeHtml(error.message)}
            </div>
        `;
    }
}

document.querySelectorAll('[data-bs-dismiss="modal"], [data-dismiss="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        const modalElement = document.getElementById('saleDetailModal');
        if (typeof jQuery !== 'undefined' && $.fn.modal) {
            $(modalElement).modal('hide');
        } else {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            modalElement.setAttribute('aria-hidden', 'true');
            modalElement.removeAttribute('aria-modal');
            modalElement.removeAttribute('role');
            
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.classList.remove('modal-open');
        }
    });
});

document.getElementById('btnFilter').addEventListener('click', function() {
    loadHistory(1);
});

document.getElementById('filterInvoice').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        loadHistory(1);
    }
});

document.getElementById('btnExportPdf').addEventListener('click', function() {
    const params = new URLSearchParams();
    const invoice = document.getElementById('filterInvoice').value.trim();
    const dateFrom = document.getElementById('filterDateFrom').value;
    const dateTo = document.getElementById('filterDateTo').value;

    if (invoice) params.set('invoice', invoice);
    if (dateFrom) params.set('date_from', dateFrom);
    if (dateTo) params.set('date_to', dateTo);

    window.open('<?= base_url('pos/export-pdf') ?>?' + params.toString(), '_blank');
});

loadHistory();
</script>

<?= $this->include('layouts/footer') ?>