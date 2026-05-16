<?php   
    require "session.php";
    require "../koneksi.php";

    // Mengambil data statistik dari database
    $querikategori = mysqli_query($koneksi," SELECT * FROM tbl_kategori");
    $jumlahkategori = mysqli_num_rows($querikategori);

    $queriproduk = mysqli_query($koneksi," SELECT * FROM tbl_produk");
    $jumlahproduk = mysqli_num_rows($queriproduk);

    $quericustomer = mysqli_query($koneksi," SELECT * FROM pelanggan");
    $jumlahcustomer = mysqli_num_rows($quericustomer);

    $queritransaksi = mysqli_query($koneksi," SELECT * FROM tbl_transaksi");
    $jumlahtransaksi = mysqli_num_rows($queritransaksi);

    $queridetailtransaksi = mysqli_query($koneksi," SELECT * FROM tbl_detail_transaksi");
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3674B5;
            --secondary-color: #A1E3F9;
            --dark-blue: #234e7a;
            --report-color: #4e73df;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            color: #333;
        }

        .no-decoration { text-decoration: none; }

        .welcome-text {
            font-weight: 700;
            color: var(--dark-blue);
            letter-spacing: -0.5px;
        }

        /* --- Card Styling --- */
        .summary-card {
            border: none;
            border-radius: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center; 
            text-align: center;
            height: 100%;
        }

        .summary-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(54, 116, 181, 0.15);
        }

        .card-icon-box {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        /* Warna Ikon */
        .icon-kategori { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }
        .icon-produk { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }
        .icon-customer { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }
        .icon-transaksi { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }
        .icon-transaksi-detail { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }
        .icon-laporan { background: rgba(54, 116, 181, 0.1); color: var(--primary-color); }

        .card-title {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 800;
            color: #333;
            margin-bottom: 15px;
        }

        .btn-detail {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-color);
            background: #f0f7ff;
            padding: 8px 20px;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-detail:hover {
            background: var(--primary-color);
            color: white !important;
        }

        .btn-laporan {
            background: var(--report-color);
            color: white !important;
        }

        .pattern-dot {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 80px;
            opacity: 0.03;
            transform: rotate(-15deg);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5 mb-5">
        <div class="mb-5">
            <h2 class="welcome-text">Halo, Admin Konveksi The Four Label! 👋</h2>
            <p class="text-muted">Berikut adalah ringkasan performa toko kamu hari ini.</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-tags pattern-dot"></i>
                    <div class="card-icon-box icon-kategori">
                        <i class="fas fa-th-list"></i>
                    </div>
                    <p class="card-title">Kategori</p>
                    <h3 class="card-value"><?php echo $jumlahkategori; ?></h3>
                    <a href="kategori.php" class="no-decoration btn-detail">
                        Kelola <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-shopping-bag pattern-dot"></i>
                    <div class="card-icon-box icon-produk">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <p class="card-title">Produk</p>
                    <h3 class="card-value"><?php echo $jumlahproduk; ?></h3>
                    <a href="produk.php" class="no-decoration btn-detail">
                        Lihat Stok <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-users pattern-dot"></i>
                    <div class="card-icon-box icon-customer">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <p class="card-title">Customer</p>
                    <h3 class="card-value"><?php echo $jumlahcustomer; ?></h3>
                    <a href="customer.php" class="no-decoration btn-detail">
                        Data Pelanggan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-money-bill-wave pattern-dot"></i>
                    <div class="card-icon-box icon-transaksi">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <p class="card-title">Transaksi</p>
                    <h3 class="card-value"><?php echo $jumlahtransaksi; ?></h3>
                    <a href="transaksi.php" class="no-decoration btn-detail">
                        Cek Nota <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-receipt pattern-dot"></i>
                    <div class="card-icon-box icon-transaksi-detail">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <p class="card-title">Detail Transaksi</p>
                    <h3 class="card-value"><?php echo $jumlahdetailtransaksi; ?></h3>
                    <a href="detail_transaksi.php" class="no-decoration btn-detail">
                        Lihat Item <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="summary-card p-4">
                    <i class="fas fa-print pattern-dot"></i>
                    <div class="card-icon-box icon-laporan">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <p class="card-title">Cetak Laporan</p>
                    <h3 class="card-value">Laporan</h3>
                    <a href="laporan.php" class="no-decoration btn-detail">
                        Buka Menu Cetak <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>