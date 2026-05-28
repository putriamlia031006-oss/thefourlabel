<?php   
    require "session.php";
    require "../koneksi.php";

    // Mengambil data statistik dari database
    $querikategori = mysqli_query($koneksi,"SELECT * FROM tbl_kategori");
    $jumlahkategori = mysqli_num_rows($querikategori);

    $queriproduk = mysqli_query($koneksi,"SELECT * FROM tbl_produk");
    $jumlahproduk = mysqli_num_rows($queriproduk);

    $quericustomer = mysqli_query($koneksi,"SELECT * FROM pelanggan");
    $jumlahcustomer = mysqli_num_rows($quericustomer);

    $queritransaksi = mysqli_query($koneksi,"SELECT * FROM tbl_transaksi");
    $jumlahtransaksi = mysqli_num_rows($queritransaksi);

    $queridetailtransaksi = mysqli_query($koneksi,"SELECT * FROM tbl_detail_transaksi");
    $jumlahdetailtransaksi = mysqli_num_rows($queridetailtransaksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Konveksi The Four Label</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.18), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.22), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .no-decoration {
            text-decoration: none;
        }

        .main-container {
            padding-top: 35px;
            padding-bottom: 50px;
        }

        .hero-dashboard {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            border-radius: 32px;
            padding: 36px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 36px rgba(76, 29, 149, 0.20);
        }

        .hero-dashboard::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.13);
            top: -100px;
            right: -70px;
        }

        .hero-dashboard::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
            bottom: -60px;
            left: 42%;
        }

        .hero-content {
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
            margin-bottom: 18px;
            backdrop-filter: blur(8px);
        }

        .hero-title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.88);
            font-size: 15px;
            line-height: 1.8;
            max-width: 680px;
            margin-bottom: 0;
        }

        .hero-icon {
            position: absolute;
            right: 38px;
            bottom: 30px;
            font-size: 95px;
            color: rgba(255, 255, 255, 0.14);
            z-index: 1;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 34px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .section-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 0;
        }

        .summary-card {
            border: none;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(12px);
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.08);
            transition: all 0.28s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
            padding: 26px;
        }

        .summary-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(76, 29, 149, 0.14);
        }

        .summary-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.07);
            right: -42px;
            top: -42px;
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            position: relative;
            z-index: 2;
        }

        .card-icon-box {
            width: 62px;
            height: 62px;
            border-radius: 21px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: var(--primary);
        }

        .card-mini-label {
            font-size: 11px;
            color: var(--primary);
            background: #f3e8ff;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 0.7px;
            text-transform: uppercase;
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 6px;
            position: relative;
            z-index: 2;
        }

        .card-value {
            font-size: 38px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 18px;
            position: relative;
            z-index: 2;
        }

        .card-footer-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
            margin-top: 8px;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            padding: 10px 18px;
            border-radius: 50px;
            transition: 0.3s;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-detail:hover {
            color: white !important;
            transform: translateX(3px);
            box-shadow: 0 10px 22px rgba(76, 29, 149, 0.25);
        }

        .pattern-icon {
            position: absolute;
            right: 24px;
            bottom: 18px;
            font-size: 64px;
            color: rgba(76, 29, 149, 0.045);
            pointer-events: none;
        }

        .quick-note {
            margin-top: 34px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(124, 58, 237, 0.09);
            border-radius: 26px;
            padding: 22px 26px;
            box-shadow: 0 10px 24px rgba(76, 29, 149, 0.06);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .quick-note-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #ede9fe;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .quick-note h6 {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .quick-note p {
            margin-bottom: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .hero-dashboard {
                padding: 28px 24px;
                border-radius: 26px;
            }

            .hero-title {
                font-size: 25px;
            }

            .hero-icon {
                display: none;
            }

            .section-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
            }

            .quick-note {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container main-container">

        <div class="hero-dashboard">
            <div class="hero-content">
                <div class="brand-badge">
                    <i class="fas fa-shirt"></i>
                    Konveksi The Four Label
                </div>

                <h2 class="hero-title">Halo, Admin! 👋</h2>

                <p class="hero-subtitle">
                    Selamat datang di dashboard admin. Pantau data produk konveksi, pelanggan,
                    transaksi pesanan, detail transaksi, dan laporan penjualan dengan lebih mudah.
                </p>
            </div>

            <i class="fas fa-store hero-icon"></i>
        </div>

        <div class="section-header">
            <div>
                <h5 class="section-title">Ringkasan Dashboard</h5>
                <p class="section-desc">Data utama sistem konveksi The Four Label.</p>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <span class="card-mini-label">Master Data</span>
                    </div>

                    <p class="card-title">Kategori Produk</p>
                    <h3 class="card-value"><?php echo $jumlahkategori; ?></h3>

                    <div class="card-footer-custom">
                        <a href="kategori.php" class="no-decoration btn-detail">
                            Kelola <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-tags pattern-icon"></i>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-shirt"></i>
                        </div>
                        <span class="card-mini-label">Produk</span>
                    </div>

                    <p class="card-title">Produk Konveksi</p>
                    <h3 class="card-value"><?php echo $jumlahproduk; ?></h3>

                    <div class="card-footer-custom">
                        <a href="produk.php" class="no-decoration btn-detail">
                            Lihat Produk <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-box-open pattern-icon"></i>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="card-mini-label">Pelanggan</span>
                    </div>

                    <p class="card-title">Data Pelanggan</p>
                    <h3 class="card-value"><?php echo $jumlahcustomer; ?></h3>

                    <div class="card-footer-custom">
                        <a href="customer.php" class="no-decoration btn-detail">
                            Lihat Data <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-user-friends pattern-icon"></i>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <span class="card-mini-label">Transaksi</span>
                    </div>

                    <p class="card-title">Transaksi Pesanan</p>
                    <h3 class="card-value"><?php echo $jumlahtransaksi; ?></h3>

                    <div class="card-footer-custom">
                        <a href="transaksi.php" class="no-decoration btn-detail">
                            Cek Transaksi <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-cash-register pattern-icon"></i>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <span class="card-mini-label">Detail</span>
                    </div>

                    <p class="card-title">Detail Pesanan</p>
                    <h3 class="card-value"><?php echo $jumlahdetailtransaksi; ?></h3>

                    <div class="card-footer-custom">
                        <a href="detail_transaksi.php" class="no-decoration btn-detail">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-receipt pattern-icon"></i>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="summary-card">
                    <div class="card-top">
                        <div class="card-icon-box">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <span class="card-mini-label">Laporan</span>
                    </div>

                    <p class="card-title">Laporan</p>
                    <h3 class="card-value">Cetak</h3>

                    <div class="card-footer-custom">
                        <a href="laporan.php" class="no-decoration btn-detail">
                            Buka Laporan <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <i class="fas fa-print pattern-icon"></i>
                </div>
            </div>

        </div>

        <div class="quick-note">
            <div class="quick-note-icon">
                <i class="fas fa-circle-info"></i>
            </div>
            <div>
                <h6>Catatan Admin</h6>
                <p>
                    Pastikan data produk, pelanggan, dan transaksi selalu diperbarui agar laporan penjualan lebih akurat.
                </p>
            </div>
        </div>

    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>