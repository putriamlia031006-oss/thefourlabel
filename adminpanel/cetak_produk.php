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
    <title>Cetak Stok Produk | The Four Label</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-light: #a78bfa;
            --primary-soft: #ede9fe;
            --bg-body: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
            --border-light: rgba(124, 58, 237, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body { 
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.18), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            font-family: 'Poppins', sans-serif; 
            color: var(--text-dark);
            min-height: 100vh;
        }

        .no-print-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 16px 24px;
            margin: 24px auto;
            max-width: 1050px;
            border: 1px solid var(--border-light);
            box-shadow: 0 10px 24px rgba(76, 29, 149, 0.08);
        }

        .btn {
            border-radius: 13px;
            font-weight: 700;
            padding: 10px 18px;
        }

        .btn-back {
            background: var(--primary-soft);
            color: var(--primary-dark);
            border: none;
        }

        .btn-back:hover {
            background: #ddd6fe;
            color: var(--primary-dark);
        }

        .btn-print {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-print:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            color: white;
        }

        .preview-title {
            color: var(--text-muted);
            font-weight: 600;
        }

        .report-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 26px;
            box-shadow: 0 14px 32px rgba(76, 29, 149, 0.10);
            padding: 42px;
            margin: 30px auto 50px;
            max-width: 1050px;
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .report-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
        }

        .kop-surat { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary-dark); 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }

        .brand-name { 
            font-size: 2rem;
            letter-spacing: 1px;
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 0;
        }

        .brand-subtitle {
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            font-weight: 800;
            font-size: 0.75rem;
        }

        .brand-info p { 
            margin: 0; 
            font-size: 0.8rem; 
            color: var(--text-muted);
            text-align: right;
            line-height: 1.5;
        }

        .brand-info .office {
            color: var(--primary-dark);
            font-weight: 800;
        }

        .report-title {
            letter-spacing: 3px;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-weight: 800;
        }

        .report-desc {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        .table {
            border-color: var(--border-light);
        }

        .table thead th { 
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 1px;
            font-weight: 800;
            color: white;
            padding: 13px 12px;
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            border: none;
            vertical-align: middle;
        }

        .table tbody td { 
            padding: 12px;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background-color: #faf5ff;
        }

        .product-name {
            font-weight: 800;
            color: var(--primary-dark);
        }

        .category-text {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 700;
            background: var(--primary-soft);
            padding: 6px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        .price-text {
            color: #15803d;
            font-weight: 800;
        }

        .status-badge {
            padding: 6px 11px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-ready {
            background: #dcfce7;
            color: #166534;
        }

        .status-out {
            background: #fee2e2;
            color: #991b1b;
        }

        .print-footer-note {
            font-size: 0.7rem !important;
            color: var(--text-muted);
        }

        .signature-text {
            color: var(--text-dark);
            font-size: 0.85rem;
        }

        @media print {
            @page { 
                size: A4 portrait; 
                margin: 1cm 1.2cm; 
            }

            .no-print {
                display: none !important;
            }
            
            body { 
                background: white !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
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
                border-radius: 0 !important;
                border: none !important;
            }

            .report-card::before {
                height: 6px;
            }

            .brand-name {
                font-size: 1.7rem;
            }

            .brand-info p {
                font-size: 0.7rem;
            }

            .report-title { 
                font-size: 1.05rem !important; 
                letter-spacing: 2px !important;
            }

            .report-desc {
                font-size: 0.72rem !important;
            }

            .table { 
                width: 100% !important; 
            }

            .table thead th { 
                font-size: 0.62rem !important; 
                padding: 8px !important; 
                background: #7c3aed !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table tbody td { 
                font-size: 0.72rem !important; 
                padding: 6px 8px !important;
                border-bottom: 1px solid #eee !important;
            }

            .status-badge,
            .category-text,
            .table tbody tr:nth-child(even) {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .d-print-flex {
                display: flex !important;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="no-print no-print-nav d-flex justify-content-between align-items-center">
        <a href="laporan.php" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>

        <h6 class="mb-0 preview-title">Pratinjau Laporan Stok Produk</h6>

        <button onclick="window.print()" class="btn btn-print px-4">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="report-card">
        <div class="kop-surat">
            <div>
                <h2 class="brand-name">THE FOUR LABEL</h2>
                <small class="brand-subtitle">Konveksi & Fashion Production</small>
            </div>

            <div class="brand-info">
                <p class="office">Tangerang Headquarters</p>
                <p>Ruko Konveksi Square Kav. 12</p>
                <p>Telp: 0838-7123-6672</p>
                <p>Email: info@thefourlabel.com</p>
            </div>
        </div>

        <div class="text-center">
            <h4 class="report-title text-uppercase">
                Laporan Inventaris Stok Produk
            </h4>
            <p class="report-desc">
                Daftar produk konveksi The Four Label beserta kategori, harga satuan, dan status ketersediaan stok.
            </p>
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
                    <td class="text-center text-muted">
                        <?= str_pad($no++, 2, "0", STR_PAD_LEFT); ?>
                    </td>

                    <td class="text-start product-name">
                        <?= $p['nama']; ?>
                    </td>

                    <td class="text-center">
                        <span class="category-text">
                            <?= $p['nama_kategori']; ?>
                        </span>
                    </td>

                    <td class="text-end price-text">
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
                <p class="print-footer-note">
                    * Laporan ini dihasilkan secara otomatis oleh sistem pada <?= date('d/m/Y H:i'); ?>.
                </p>
            </div>

            <div class="col-4 text-center signature-text">
                <p class="mb-1">Tangerang, <?= date('d F Y'); ?></p>
                <p class="fw-bold mb-5 pb-4">Admin Operasional,</p>
                <br>
                <p class="mb-0 fw-bold">( The Four Label Admin )</p>
                <hr class="mt-0 mx-auto" style="width: 85%; border-top: 1.5px solid #000;">
            </div>
        </div>
    </div>
</div>

<script src="../fontawesome/js/all.min.js"></script>

</body>
</html>