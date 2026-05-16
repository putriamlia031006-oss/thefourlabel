<?php
require "session.php";
require "../koneksi.php";

// Query dengan JOIN untuk mengambil nama kategori
$queryProduk = mysqli_query($koneksi, "
    SELECT p.*, k.nama as nama_kategori 
    FROM tbl_produk p 
    LEFT JOIN tbl_kategori k ON p.id_kategori = k.id_kategori
    ORDER BY p.nama ASC
");

if (!$queryProduk) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Produk | Fashion Gassspol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary-color: #2d3436;
            --accent-color: #0984e3;
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
            max-width: 1000px;
        }

        .no-print-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px 25px;
            margin: 20px auto;
            max-width: 1000px;
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

        /* TABEL DESIGN */
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

        .status-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-ready { background: #e3fcef; color: #00b894; }
        .status-out { background: #fff0f0; color: #d63031; }

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

            /* Mengecilkan font agar terlihat melebar */
            .brand-name { font-size: 1.8rem; }
            .brand-info p { font-size: 0.7rem; }

            .table { 
                width: 100% !important; 
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

            .status-badge {
                border: 0.5px solid #ccc !important;
                font-size: 0.6rem !important;
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
        <h6 class="mb-0 text-muted fw-normal">Pratinjau Inventaris Produk</h6>
        <button onclick="window.print()" class="btn btn-primary px-4">Cetak Laporan</button>
    </div>

    <div class="report-card">
        <div class="kop-surat">
            <div>
                <h2 class="brand-name mb-0">FASHION GASSSPOL</h2>
                <small class="text-uppercase" style="letter-spacing: 2px; color: #a2a2a2; font-weight:700;">Inventory Report</small>
            </div>
            <div class="brand-info">
                <p class="fw-bold" style="color:#000;">Tangerang Headquarters</p>
                <p>Ruko Fashion Square Kav. 12</p>
                <p>Telp: (62) 838-7123-6672</p>
                <p>Email: info@fashiongassspol.com</p>
            </div>
        </div>

        <div class="text-center">
            <h4 class="report-title text-uppercase fw-bold" style="letter-spacing: 4px; color: #2d3436; margin-bottom: 30px;">Laporan Inventaris Stok Produk</h4>
        </div>

        <table class="table align-middle">
            <thead class="text-center">
                <tr>
                    <th width="5%">No.</th>
                    <th class="text-start">Nama Produk</th>
                    <th width="20%">Kategori</th>
                    <th width="20%">Harga Satuan</th>
                    <th width="15%">Ketersediaan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while($p = mysqli_fetch_assoc($queryProduk)){ 
                ?>
                <tr>
                    <td class="text-center text-muted"><?= str_pad($no++, 2, "0", STR_PAD_LEFT); ?></td>
                    <td class="text-start fw-semibold"><?= $p['nama']; ?></td>
                    <td class="text-center">
                        <span class="text-muted" style="font-size: 0.75rem;"><?= $p['nama_kategori']; ?></span>
                    </td>
                    <td class="text-end fw-bold">
                        Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                    </td>
                    <td class="text-center">
                        <?php if($p['ketersediaan_stok'] == 'tersedia'): ?>
                            <span class="status-badge status-ready">Ready</span>
                        <?php else: ?>
                            <span class="status-badge status-out">Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="row mt-5 pt-4 d-none d-print-flex justify-content-between">
            <div class="col-8">
                <p class="small text-muted italic" style="font-size: 0.65rem !important;">
                    * Laporan ini dihasilkan secara otomatis oleh sistem pada <?= date('d/m/Y H:i'); ?>.
                </p>
            </div>
            <div class="col-4 text-center">
                <p class="mb-1">Tangerang, <?= date('d F Y'); ?></p>
                <p class="fw-bold mb-5 pb-4">Admin Operasional,</p>
                <br>
                <p class="mb-0 fw-bold">( Fashion Gassspol Admin )</p>
                <hr class="mt-0 mx-auto" style="width: 85%; border-top: 1.5px solid #000;">
            </div>
        </div>
    </div>
</div>

</body>
</html>