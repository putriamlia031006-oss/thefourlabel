<?php
require "session.php";
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Laporan | The Four Label</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-soft: #ede9fe;
            --primary-light: #a78bfa;
            --bg-main: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.16), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.20), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .header-lavender {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            min-height: 250px;
            padding: 58px 20px 90px;
            color: white;
            border-radius: 0 0 44px 44px;
            box-shadow: 0 16px 34px rgba(76, 29, 149, 0.20);
            position: relative;
            overflow: hidden;
        }

        .header-lavender::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            top: -100px;
            right: -65px;
        }

        .header-lavender::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.09);
            border-radius: 50%;
            bottom: -70px;
            left: 15%;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.24);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
            backdrop-filter: blur(8px);
        }

        .brand-title {
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.86);
            font-size: 15px;
            margin-bottom: 0;
        }

        .report-container {
            margin-top: -62px;
            margin-bottom: 80px;
            position: relative;
            z-index: 5;
        }

        .card-report {
            border: none;
            border-radius: 28px;
            transition: all 0.3s ease;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            overflow: hidden;
            border: 1px solid rgba(124, 58, 237, 0.09);
            position: relative;
        }

        .card-report::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.07);
            right: -45px;
            top: -45px;
        }

        .card-report:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 36px rgba(76, 29, 149, 0.14);
        }

        .card-body {
            position: relative;
            z-index: 2;
        }

        .icon-circle {
            width: 86px;
            height: 86px;
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            color: var(--primary);
            font-size: 34px;
            transition: 0.3s;
        }

        .card-report:hover .icon-circle {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 10px 24px rgba(124, 58, 237, 0.25);
        }

        .report-name {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 20px;
        }
        
        .report-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 26px;
            min-height: 58px;
        }

        .btn-cetak {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
            border-radius: 14px;
            padding: 13px 20px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-cetak:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(76, 29, 149, 0.26);
        }

        .back-link {
            transition: 0.3s;
            color: var(--text-muted);
        }

        .back-link:hover {
            color: var(--primary) !important;
        }

        .report-note {
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(124, 58, 237, 0.09);
            border-radius: 24px;
            padding: 20px 24px;
            margin-top: 34px;
            box-shadow: 0 10px 24px rgba(76, 29, 149, 0.06);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .report-note-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .report-note h6 {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .report-note p {
            margin-bottom: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .header-lavender {
                padding-top: 44px;
                border-radius: 0 0 34px 34px;
            }

            .brand-title {
                font-size: 27px;
            }

            .report-note {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<?php require "navbar.php"; ?>

<div class="header-lavender text-center">
    <div class="header-content">
        <div class="brand-badge">
            <i class="fas fa-shirt"></i>
            Konveksi The Four Label
        </div>

        <h1 class="brand-title">Pusat Laporan</h1>
        <p class="brand-subtitle">
            Cetak laporan transaksi dan stok produk konveksi dengan mudah.
        </p>
    </div>
</div>

<div class="container report-container">
    <div class="row g-4 justify-content-center">

        <div class="col-lg-5 col-md-6">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-receipt"></i>
                    </div>

                    <h5 class="report-name">Laporan Transaksi</h5>

                    <p class="report-desc">
                        Menampilkan data transaksi pesanan, pembayaran, dan riwayat penjualan yang tercatat di sistem.
                    </p>

                    <a href="cetak_transaksi.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan Transaksi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-6">
            <div class="card card-report h-100 text-center p-4">
                <div class="card-body">
                    <div class="icon-circle">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>

                    <h5 class="report-name">Laporan Stok Produk</h5>

                    <p class="report-desc">
                        Menampilkan daftar produk konveksi, jumlah stok, harga, dan informasi produk yang tersedia.
                    </p>

                    <a href="cetak_produk.php" class="btn btn-cetak w-100">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan Stok Produk
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="report-note">
        <div class="report-note-icon">
            <i class="fas fa-circle-info"></i>
        </div>

        <div>
            <h6>Catatan Laporan</h6>
            <p>
                Pastikan data transaksi dan stok produk sudah diperbarui sebelum mencetak laporan.
            </p>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="index.php" class="text-decoration-none fw-bold back-link">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard Utama
        </a>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>