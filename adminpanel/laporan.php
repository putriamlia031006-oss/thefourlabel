<?php
require "session.php";
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Laporan | Admin Fashion Gassspol</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <style>
        :root {
            --primary-color: #2d3436;
            --accent-color: #0984e3; /* Biru sesuai screenshot */
            --bg-light: #f4f7fe;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
        }

        .header-blue {
            background: linear-gradient(135deg, var(--accent-color) 0%, #076ad8 100%);
            height: 240px;
            padding-top: 60px;
            color: white;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 10px 25px rgba(9, 132, 227, 0.2);
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }

        .card-report {
            border: none;
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            background: #ffffff;
            overflow: hidden;
        }

        .card-report:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(9, 132, 227, 0.15);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: #f0f7ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--accent-color);
            font-size: 34px;
            transition: 0.3s;
        }

        /* DEFAULT HOVER: Background Biru, Ikon Putih */
        .card-report:hover .icon-circle {
            background: var(--accent-color);
            color: white;
        }

        /* KHUSUS DETAIL TRANSAKSI: Hover Ikon TETAP BIRU */
        .card-detail-khusus:hover .icon-circle {
            background: #f0f7ff !important;
            color: var(--accent-color) !important;
        }

        .btn-cetak {
            background-color: var(--accent-color);
            color: white;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-cetak:hover {
            background-color: #076ad8;
            color: white;
            box-shadow: 0 8px 15px rgba(9, 132, 227, 0.3);
        }

        .report-name {
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 10px;
        }
        
        .report-desc {
            font-size: 0.85rem;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 25px;
            min-height: 40px;
        }

        .back-link {
            transition: 0.3s;
            opacity: 0.7;
        }

        .back-link:hover {
            opacity: 1;
            color: var(--accent-color) !important;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="header-blue text-center">
    <h1 class="brand-title fw-bold">FASHION GASSSPOL</h1>
    <p class="opacity-75">Pusat Administrasi & Laporan Digital</p>
</div>

<div class="container" style="margin-top: -70px; margin-bottom: 80px;">
    <div class="row g-4 justify-content-center">

        <div class="col-md-4">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="report-name">Laporan Kategori</h5>
                    <p class="report-desc">Daftar klasifikasi kategori produk yang tersedia di sistem.</p>
                    <a href="cetak_kategori.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="report-name">Laporan Produk</h5>
                    <p class="report-desc">Data stok, harga gudang, dan inventaris barang terkini.</p>
                    <a href="cetak_produk.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="report-name">Laporan Customer</h5>
                    <p class="report-desc">Informasi data pelanggan dan database kontak marketing.</p>
                    <a href="cetak_customer.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h5 class="report-name">Laporan Transaksi</h5>
                    <p class="report-desc">Ringkasan total pendapatan harian dan status pesanan.</p>
                    <a href="cetak_transaksi.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5 class="report-name">Laporan Detail Transaksi</h5>
                    <p class="report-desc">Rincian produk terjual, kuantitas, dan omset per item secara mendalam.</p>
                    <a href="cetak_detail_transaksi.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-5">
        <a href="index.php" class="text-decoration-none text-muted fw-bold back-link">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard Utama
        </a>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>