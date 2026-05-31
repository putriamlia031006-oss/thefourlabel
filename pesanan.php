<?php
session_start();
require "koneksi.php";

// =========================
// VALIDASI LOGIN
// =========================
if(!isset($_SESSION['pelanggan'])){
    echo "
    <script>
        alert('Silakan login terlebih dahulu');
        location='login.php';
    </script>
    ";
    exit;
}

// =========================
// AMBIL DATA LOGIN
// =========================
$id_pelanggan   = $_SESSION['pelanggan']['id_pelanggan'];
$nama_pelanggan = $_SESSION['pelanggan']['nama_pelanggan'];

// =========================
// QUERY PESANAN
// =========================
$query = mysqli_query($koneksi,"
    SELECT *
    FROM tbl_transaksi
    WHERE id_pelanggan = '$id_pelanggan'
    ORDER BY id_transaksi DESC
");

if(!$query){
    die("Query Error : ".mysqli_error($koneksi));
}

function statusClass($status){
    $status = strtolower($status);

    if($status == 'proses' || $status == 'diproses'){
        return 'status-proses';
    } elseif($status == 'selesai'){
        return 'status-selesai';
    } elseif($status == 'dibatalkan' || $status == 'batal'){
        return 'status-batal';
    } else {
        return 'status-pending';
    }
}

function statusText($status){
    $status = strtolower($status);

    if($status == 'proses' || $status == 'diproses'){
        return 'Proses';
    } elseif($status == 'selesai'){
        return 'Selesai';
    } elseif($status == 'dibatalkan' || $status == 'batal'){
        return 'Dibatalkan';
    } else {
        return 'Pending';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | The Four Label</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
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
            --white: #ffffff;
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

        .navbar-custom {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            box-shadow: 0 10px 24px rgba(76, 29, 149, 0.16);
            padding: 18px 0;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 1px;
            color: white !important;
            font-size: 22px;
        }

        .user-greeting {
            color: rgba(255, 255, 255, 0.92);
            font-weight: 500;
        }

        .user-greeting b {
            color: white;
            font-weight: 800;
        }

        .page-wrapper {
            padding-top: 42px;
            padding-bottom: 70px;
        }

        .hero-card {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            border-radius: 30px;
            padding: 34px;
            color: white;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 36px rgba(76, 29, 149, 0.18);
        }

        .hero-card::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            top: -90px;
            right: -60px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.24);
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .hero-title {
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 15px;
        }

        .card-order {
            border: none;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 14px 32px rgba(76, 29, 149, 0.10);
            overflow: hidden;
            border: 1px solid rgba(124, 58, 237, 0.09);
        }

        .table-header {
            padding: 26px 30px 18px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        }

        .table-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 5px;
            font-size: 22px;
        }

        .table-subtitle {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 14px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 17px 18px;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .table tbody td {
            padding: 18px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(124, 58, 237, 0.07);
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #faf5ff;
        }

        .trx-code {
            color: var(--primary);
            font-weight: 800;
            background: var(--primary-soft);
            padding: 8px 13px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .product-badge {
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 8px 13px;
            border-radius: 50px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .price-text {
            color: #15803d;
            font-weight: 800;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-proses {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-selesai {
            background: #dcfce7;
            color: #166534;
        }

        .status-batal {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-detail {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 9px 15px;
            font-weight: 800;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-detail:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.22);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd6fe;
            margin-bottom: 14px;
        }

        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            color: white;
            border: none;
            padding: 24px;
        }

        .modal-title {
            font-weight: 800;
        }

        .btn-close {
            filter: invert(1);
        }

        .detail-product {
            border: 1px solid rgba(124, 58, 237, 0.10);
            border-radius: 18px;
            padding: 16px;
            background: #fbfaff;
            margin-bottom: 12px;
        }

        .detail-img {
            width: 62px;
            height: 62px;
            object-fit: cover;
            border-radius: 14px;
            background: #eee;
        }

        .detail-name {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 4px;
        }

        .detail-total {
            color: var(--primary);
            font-weight: 800;
        }

        .summary-detail {
            background: var(--primary-soft);
            border-radius: 18px;
            padding: 18px;
            color: var(--primary-dark);
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .hero-card {
                border-radius: 24px;
                padding: 28px 24px;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid rgba(124, 58, 237, 0.12);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                border: none;
                padding: 9px 0;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 800;
                color: var(--primary-dark);
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-custom mb-4">
    <div class="container">
        <a href="index.php" class="navbar-brand">
            <i class="fa fa-store me-2"></i>THE FOUR LABEL
        </a>

        <span class="user-greeting">
            Halo, <b><?= htmlspecialchars($nama_pelanggan); ?></b>
        </span>
    </div>
</nav>

<div class="container page-wrapper">

    <div class="hero-card">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fa fa-receipt"></i>
                Riwayat Transaksi
            </div>

            <h2 class="hero-title">
                Riwayat Pesanan Saya
            </h2>

            <p class="hero-desc">
                Pantau status pesanan, total pembayaran, dan detail produk yang sudah kamu checkout.
            </p>
        </div>
    </div>

    <div class="card card-order">

        <div class="table-header">
            <h4 class="table-title">
                <i class="fa fa-list me-2"></i>Daftar Pesanan
            </h4>
            <p class="table-subtitle">
                Semua transaksi yang tercatat pada akun kamu.
            </p>
        </div>

        <?php if(mysqli_num_rows($query) > 0){ ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Produk</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while($data = mysqli_fetch_assoc($query)){ ?>

                        <?php
                            $id_transaksi = $data['id_transaksi'];
                            $status = $data['status_transaksi'];
                            $class = statusClass($status);
                            $status_tampil = statusText($status);

                            $queryDetail = mysqli_query($koneksi, "
                                SELECT 
                                    dt.*,
                                    p.nama,
                                    p.harga,
                                    p.foto
                                FROM tbl_detail_transaksi dt
                                LEFT JOIN tbl_produk p ON dt.id_produk = p.id
                                WHERE dt.id_transaksi = '$id_transaksi'
                            ");

                            if(!$queryDetail){
                                die("Query Detail Error : ".mysqli_error($koneksi));
                            }

                            $detail_items = [];
                            $total_detail = 0;

                            while($detail = mysqli_fetch_assoc($queryDetail)){
                                $detail_items[] = $detail;
                                $harga_produk = isset($detail['harga']) ? $detail['harga'] : 0;
                                $jumlah_produk = isset($detail['jumlah']) ? $detail['jumlah'] : 0;
                                $total_detail += $harga_produk * $jumlah_produk;
                            }
                        ?>

                        <tr>
                            <td data-label="No Transaksi">
                                <span class="trx-code">
                                    <i class="fa fa-receipt"></i>
                                    #TRX-<?= $id_transaksi; ?>
                                </span>
                            </td>

                            <td data-label="Tanggal">
                                <?= date('d F Y', strtotime($data['tanggal_transaksi'])); ?>
                            </td>

                            <td data-label="Total Produk">
                                <span class="product-badge">
                                    <i class="fa fa-box"></i>
                                    <?= $data['total_produk']; ?> Produk
                                </span>
                            </td>

                            <td data-label="Total Harga">
                                <span class="price-text">
                                    Rp <?= number_format($data['total_harga'],0,',','.'); ?>
                                </span>
                            </td>

                            <td data-label="Status">
                                <span class="status-badge <?= $class; ?>">
                                    <i class="fa fa-circle"></i>
                                    <?= $status_tampil; ?>
                                </span>
                            </td>

                            <td data-label="Aksi" class="text-center">
                                <button type="button"
                                        class="btn btn-detail"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal<?= $id_transaksi; ?>">
                                    <i class="fa fa-eye me-1"></i>
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL DETAIL -->
                        <div class="modal fade" id="detailModal<?= $id_transaksi; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title">
                                                Detail Pesanan #TRX-<?= $id_transaksi; ?>
                                            </h5>
                                            <small>
                                                <?= date('d F Y', strtotime($data['tanggal_transaksi'])); ?>
                                            </small>
                                        </div>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-4">

                                        <div class="row mb-4">
                                            <div class="col-md-4 mb-3">
                                                <small class="text-muted fw-bold text-uppercase">Status</small>
                                                <div>
                                                    <span class="status-badge <?= $class; ?>">
                                                        <i class="fa fa-circle"></i>
                                                        <?= $status_tampil; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <small class="text-muted fw-bold text-uppercase">Total Produk</small>
                                                <div class="fw-bold">
                                                    <?= $data['total_produk']; ?> Produk
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <small class="text-muted fw-bold text-uppercase">Total Harga</small>
                                                <div class="price-text">
                                                    Rp <?= number_format($data['total_harga'],0,',','.'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="fw-bold mb-3" style="color: var(--primary-dark);">
                                            <i class="fa fa-shirt me-2"></i>Produk dalam Pesanan
                                        </h6>

                                        <?php if(count($detail_items) > 0){ ?>

                                            <?php foreach($detail_items as $item){ ?>

                                                <?php
                                                    $nama_produk = $item['nama'] ?? 'Produk tidak ditemukan';
                                                    $foto_produk = $item['foto'] ?? '';
                                                    $harga_produk = $item['harga'] ?? 0;
                                                    $jumlah_produk = $item['jumlah'] ?? 0;
                                                    $subtotal = $harga_produk * $jumlah_produk;
                                                ?>

                                                <div class="detail-product">
                                                    <div class="d-flex align-items-center">
                                                        <?php if($foto_produk != ''){ ?>
                                                            <img src="image/<?= $foto_produk; ?>" class="detail-img me-3">
                                                        <?php } else { ?>
                                                            <div class="detail-img me-3 d-flex align-items-center justify-content-center">
                                                                <i class="fa fa-image text-muted"></i>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="flex-grow-1">
                                                            <div class="detail-name">
                                                                <?= htmlspecialchars($nama_produk); ?>
                                                            </div>

                                                            <small class="text-muted">
                                                                <?= $jumlah_produk; ?> x Rp <?= number_format($harga_produk,0,',','.'); ?>
                                                            </small>
                                                        </div>

                                                        <div class="detail-total">
                                                            Rp <?= number_format($subtotal,0,',','.'); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                            <div class="summary-detail d-flex justify-content-between mt-3">
                                                <span>Total Produk</span>
                                                <span>Rp <?= number_format($total_detail,0,',','.'); ?></span>
                                            </div>

                                        <?php } else { ?>

                                            <div class="alert alert-warning rounded-4">
                                                <i class="fa fa-exclamation-circle me-2"></i>
                                                Detail produk belum tersedia untuk transaksi ini.
                                                Kemungkinan transaksi dibuat sebelum proses checkout menyimpan data ke tabel
                                                <b>tbl_detail_transaksi</b>.
                                            </div>

                                        <?php } ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    </tbody>

                </table>
            </div>

        <?php }else{ ?>

            <div class="empty-state">
                <i class="fa fa-shopping-bag"></i>
                <h5 class="fw-bold">Belum ada pesanan</h5>
                <p class="mb-3">Pesanan kamu akan muncul setelah melakukan checkout.</p>
                <a href="produk.php" class="btn btn-detail">
                    Mulai Belanja
                </a>
            </div>

        <?php } ?>

    </div>

</div>

<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>

</body>
</html>