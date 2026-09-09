<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            color: #333; 
            margin: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .header h2 { 
            margin: 0; 
            padding: 0; 
            font-size: 16px;
        }
        .header p { 
            margin: 5px 0; 
            color: #666; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f4f4f4; 
            font-weight: bold;
        }
        .text-end { 
            text-align: right; 
        }
        .text-center { 
            text-align: center; 
        }
        .footer-print {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #555;
        }
        
        /* Pengaturan Cetak (Print) */
        @media print {
            body {
                margin: 10mm;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2><?= esc($setting['store_name'] ?? 'Laporan Penjualan') ?></h2>
        <hr style="border: 0; border-top: 1px solid #ccc; margin: 10px 0;">
        <strong>REKAPITULASI PENJUALAN</strong>
        <?php if (!empty($dateFrom) || !empty($dateTo)) : ?>
            <p>Periode: <?= esc($dateFrom ?? 'Awal') ?> s/d <?= esc($dateTo ?? 'Sekarang') ?></p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Kasir</th>
                <th class="text-end">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sales)) : ?>
                <?php $no = 1; $grandTotal = 0; foreach ($sales as $row) : ?>
                    <?php $grandTotal += $row['final_price']; ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($row['invoice']) ?></td>
                        <td><?= esc($row['created']) ?></td>
                        <td><?= esc($row['customer_name'] ?? 'Umum') ?></td>
                        <td><?= esc($row['cashier_name'] ?? '-') ?></td>
                        <td class="text-end"><?= number_format($row['final_price'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                    <td class="text-end"><strong>Rp <?= number_format($grandTotal, 0, ',', '.') ?></strong></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Informasi Tanggal Cetak & Tanda Tangan -->
    <div class="footer-print">
        <div>
            <span>Dicetak pada: <?= date('d/m/Y H:i:s') ?></span>
        </div>
</body>
</html>