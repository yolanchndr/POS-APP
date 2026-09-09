<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($sale['invoice']) ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 5px;
            background: #f5f6fa;
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            font-size: 10px; /* Diperkecil sedikit agar pas di 58mm */
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .receipt-container {
            width: 100%;
            max-width: 58mm; /* Sesuaikan dengan lebar printer */
            background: #fff;
            padding: 5mm; /* Padding diperkecil */
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .receipt {
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .store-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 5px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
        }

        .total {
            font-size: 12px;
            font-weight: bold;
        }

        .footer {
            margin-top: 8px;
            text-align: center;
            font-size: 9px;
        }

        .print-container {
            width: 100%;
            max-width: 58mm;
            text-align: center;
        }

        .print-button {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            border: 0;
            background: #212529;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: background 0.2s;
        }

        .print-button:hover {
            background: #000;
        }

        /* Pengaturan Khusus Printer Thermal (58mm) */
        @media print {
            @page {
                size: 58mm auto;
                margin: 0mm;
            }

            body {
                background: #fff;
                padding: 0;
                display: block;
                width: 58mm;
            }

            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 2mm; /* Padding cetak minimal agar muat */
                max-width: 58mm;
                width: 58mm;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

<div class="receipt-container">
    <div class="receipt">
        <!-- HEADER TOKO DINAMIS DARI DATABASE -->
        <div class="center">
            <div class="store-name"><?= esc($setting['store_name']) ?></div>
            <div><?= $setting['store_address'] ?></div>
            <div>Telp. <?= esc($setting['store_phone']) ?></div>
        </div>

        <div class="line"></div>

        <div>
            <div class="row">
                <span>Invoice</span>
                <strong><?= esc($sale['invoice']) ?></strong>
            </div>
            <div class="row">
                <span>Tanggal</span>
                <span><?= date('d/m/Y H:i', strtotime($sale['created'])) ?></span>
            </div>
            <div class="row">
                <span>Kasir</span>
                <span><?= esc($sale['cashier_name']) ?></span>
            </div>
            <div class="row">
                <span>Customer</span>
                <span><?= esc($sale['customer_name'] ?? 'Umum') ?></span>
            </div>
        </div>

        <div class="line"></div>

        <?php foreach ($details as $item) : ?>
            <div>
                <div class="item-name">
                    <?= esc($item['item_name']) ?>
                </div>
                <div class="item-detail">
                    <span>
                        <?= $item['qty'] ?> x <?= number_format($item['price'], 0, ',', '.') ?>
                    </span>
                    <span>
                        Rp <?= number_format($item['total'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
            <div style="height:3px"></div>
        <?php endforeach; ?>

        <div class="line"></div>

        <div class="row">
            <span>Subtotal</span>
            <span>Rp <?= number_format($sale['total_price'], 0, ',', '.') ?></span>
        </div>

        <div class="row">
            <span>Diskon</span>
            <span>Rp <?= number_format($sale['discount'], 0, ',', '.') ?></span>
        </div>

        <div class="line"></div>

        <div class="row total">
            <span>TOTAL</span>
            <span>Rp <?= number_format($sale['final_price'], 0, ',', '.') ?></span>
        </div>

        <div style="height:4px"></div>

        <div class="row">
            <span>Tunai</span>
            <span>Rp <?= number_format($sale['cash'], 0, ',', '.') ?></span>
        </div>

        <div class="row">
            <span>Kembalian</span>
            <span>Rp <?= number_format($sale['uang_kembalian'], 0, ',', '.') ?></span>
        </div>

        <div class="line"></div>

        <!-- FOOTER / CATATAN KAKI DINAMIS DARI DATABASE -->
        <div class="footer">
            <?= nl2br(esc($setting['receipt_footer'])) ?>
        </div>
    </div>
</div>

<div class="print-container no-print">
    <button class="print-button" onclick="window.print()">
        Cetak Struk
    </button>
</div>

</body>
</html>