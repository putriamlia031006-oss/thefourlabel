<?php
require "session.php";
require "../koneksi.php";

// Query mengambil semua detail transaksi dengan join produk dan transaksi
$querySemuaDetail = mysqli_query($koneksi, "
    SELECT 
        dt.id_detail, 
        dt.id_transaksi, 
        dt.jumlah, 
        p.nama as nama_produk, 
        p.harga, 
        t.tanggal_transaksi
    FROM tbl_detail_transaksi dt
    JOIN tbl_produk p ON dt.id_produk = p.id
    JOIN tbl_transaksi t ON dt.id_transaksi = t.id_transaksi
    ORDER BY dt.id_transaksi DESC
");

if (!$querySemuaDetail) {
    die("Query Gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Transaksi | Fashion Gassspol</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary-color: #2d3436;
            --accent-color: #0984e3; /* Biru Cerah sesuai tema Customer */
            --text-muted: #636e72;
            --border-light: #dfe6e9;
        }

        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', sans-serif; 
            color: var(--primary-color);
        }

        /* TAMPILAN LAYAR (BROWSER) */
        .report-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            margin: 40px auto;
            max-width: 1100px;
        }

        .no-print-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px 25px;
            margin: 20px auto;
            max-width: 1100px;
            border: 1px solid var(--border-light);
        }

        .kop-surat { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary-color); 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }

        .brand-name { 
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            letter-spacing: 1px;
            color: var(--primary-color);
        }

        .brand-info p { 
            margin: 0; 
            font-size: 0.8rem; 
            color: var(--text-muted);
            text-align: right;
            line-height: 1.4;
        }

        /* TABEL DESIGN - DISAMAKAN DENGAN TEMA CUSTOMER */
        .table thead th { 
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            font-weight: 700;
            color: var(--text-muted);
            padding: 12px;
            background-color: #f8f9fa;
            border: none;
        }

        .table tbody td { 
            padding: 10px 12px;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-light);
        }

        .trx-badge {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--accent-color);
            background: #e1f0ff;
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* =========================================
           CSS KHUSUS CETAK (PRINT OPTIMIZATION)
           ========================================= */
        @media print {
            @page { 
                size: A4 portrait; 
                margin: 1cm 1.2cm; 
            }

            .no-print { display: none !important; }
            
            body { 
                background: white !important; 
                -webkit-print-color-adjust: exact; 
            }

            .container { 
                max-width: 100% !important; 
                width: 100% !important; 
                padding: 0 !important; 
                margin: 0 !important; 
            }

            .report-card { 
                box-shadow: none !important; 
                padding: 0 !important; 
                margin: 0 !important; 
                max-width: 100% !important; 
            }

            .table thead th { 
                font-size: 0.65rem !important; 
                padding: 8px !important; 
                background-color: #f8f9fa !important;
                border-bottom: 1px solid #000 !important;
            }

            .table tbody td { 
                font-size: 0.75rem !important; 
                padding: 6px 10px !important;
                border-bottom: 1px solid #eee !important;
            }

            .report-title { 
                font-size: 1.1rem !important; 
                letter-spacing: 3px !important;
            }

            .d-print-flex { display: flex !important; }
        }

        .btn { border-radius: 8px; font-weight: 600; }
        .btn-primary { background: var(--accent-color); border: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="no-print no-print-nav d-flex justify-content-between align-items-center">
        <a href="laporan.php" class="btn btn-light text-muted">← Kembali</a>
        <h6 class="mb-0 text-muted fw-normal">Pratinjau Detail Transaksi</h6>
        <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm">Cetak Sekarang</button>
    </div>

    <div class="report-card">
        <div class="kop-surat">
            <div>
                <h2 class="brand-name mb-0">KONVEKSI THE FOUR LABEL</h2>
                <small class="text-uppercase" style="letter-spacing: 2px; color: #a2a2a2; font-weight:700;">Sales Detail Report</small>
            </div>
            <div class="brand-info">
                <p class="fw-bold" style="color:#000;">Tangerang Headquarters</p>
                <p>Ruko Fashion Square Kav. 12</p>
                <p>Telp: (62) 838-7123-6672</p>
                <p>Email: info@thefourlabel.com</p>
            </div>
        </div>

        <div class="text-center">
            <h4 class="report-title text-uppercase fw-bold" style="letter-spacing: 4px; color: #2d3436; margin-bottom: 30px;">Laporan Detail Transaksi</h4>
        </div>

        <table class="table align-middle">
            <thead class="text-center">
                <tr>
                    <th width="5%">No.</th>
                    <th width="12%">ID TRX</th>
                    <th width="13%">Tanggal</th>
                    <th class="text-start">Nama Produk</th>
                    <th width="8%">Qty</th>
                    <th width="15%" class="text-end">Harga</th>
                    <th width="18%" class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; $grand_total = 0;
                while($item = mysqli_fetch_assoc($querySemuaDetail)) { 
                    $subtotal = $item['harga'] * $item['jumlah'];
                    $grand_total += $subtotal;
                ?>
                <tr>
                    <td class="text-center text-muted"><?= str_pad($no++, 2, "0", STR_PAD_LEFT); ?></td>
                    <td class="text-center">
                        <span class="trx-badge">#<?= $item['id_transaksi']; ?></span>
                    </td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($item['tanggal_transaksi'])); ?></td>
                    <td class="text-start fw-semibold text-dark"><?= $item['nama_produk']; ?></td>
                    <td class="text-center"><?= $item['jumlah']; ?></td>
                    <td class="text-end text-muted">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td class="text-end fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot style="border-top: 2px solid var(--primary-color);">
                <tr>
                    <td colspan="6" class="text-end py-3 fw-bold text-uppercase" style="font-size: 0.75rem;">Total Seluruh Omset Produk</td>
                    <td class="text-end fw-bold" style="font-size: 1rem; color: var(--accent-color);">
                        Rp <?= number_format($grand_total, 0, ',', '.'); ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-4 d-none d-print-flex justify-content-between">
            <div class="col-8">
                <p class="small text-muted italic" style="font-size: 0.65rem !important;">
                    * Laporan detail transaksi ini dihasilkan secara otomatis oleh sistem pada <?= date('d/m/Y H:i'); ?>.
                </p>
            </div>
            <div class="col-4 text-center">
                <p class="mb-1">Tangerang, <?= date('d F Y'); ?></p>
                <p class="fw-bold mb-5 pb-4">Admin Operasional,</p>
                <br>
                <p class="mb-0 fw-bold">( Konveksi The Four Label Admin )</p>
                <hr class="mt-0 mx-auto" style="width: 85%; border-top: 1.5px solid #000;">
            </div>
        </div>
    </div>
</div>

</body>
</html>