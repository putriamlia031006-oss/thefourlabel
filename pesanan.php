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
// NOTE:
// tbl_transaksi memakai id_customer
// sedangkan login memakai id_pelanggan
// =========================
$query = mysqli_query($koneksi,"
    SELECT *
    FROM tbl_transaksi
    WHERE id_pelanggan = '$id_pelanggan'
    ORDER BY id_transaksi DESC
");

// =========================
// DEBUG ERROR SQL
// =========================
if(!$query){
    die("Query Error : ".mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">

    <style>

        body{
            background:#f5f6fa;
            font-family:Arial, Helvetica, sans-serif;
        }

        .navbar{
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .card-order{
            border:none;
            border-radius:18px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        .status-badge{
            padding:7px 18px;
            border-radius:50px;
            font-size:13px;
            font-weight:bold;
            display:inline-block;
        }

        .status-pending{
            background:#fff3cd;
            color:#856404;
        }

        .status-proses{
            background:#cff4fc;
            color:#055160;
        }

        .status-selesai{
            background:#d1e7dd;
            color:#0f5132;
        }

        .table thead th{
            background:#f8f9fa;
            text-transform:uppercase;
            font-size:13px;
        }

    </style>

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark mb-4">

    <div class="container">

        <a href="index.php"
           class="navbar-brand fw-bold text-success">

            THE FOUR LABEL

        </a>

        <span class="text-white">

            Halo,
            <b><?= htmlspecialchars($nama_pelanggan); ?></b>

        </span>

    </div>

</nav>

<!-- CONTENT -->
<div class="container">

    <div class="card card-order">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">

                Riwayat Pesanan Saya

            </h3>

            <?php if(mysqli_num_rows($query) > 0){ ?>

            <div class="table-responsive">

                <table class="table table-hover align-middle border">

                    <thead>

                        <tr>

                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Produk</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while($data = mysqli_fetch_assoc($query)){ ?>

                        <?php

                        $status = strtolower($data['status_transaksi']);

                        if($status == 'proses'){

                            $class = 'status-proses';

                        }elseif($status == 'selesai'){

                            $class = 'status-selesai';

                        }else{

                            $class = 'status-pending';

                        }

                        ?>

                        <tr>

                            <td>

                                <span class="fw-bold text-primary">

                                    #TRX-<?= $data['id_transaksi']; ?>

                                </span>

                            </td>

                            <td>

                                <?= date('d F Y', strtotime($data['tanggal_transaksi'])); ?>

                            </td>

                            <td>

                                <?= $data['total_produk']; ?> Produk

                            </td>

                            <td class="fw-bold text-success">

                                Rp <?= number_format($data['total_harga'],0,',','.'); ?>

                            </td>

                            <td>

                                <span class="status-badge <?= $class; ?>">

                                    <?= ucfirst($data['status_transaksi']); ?>

                                </span>

                            </td>

                            <td>

                                <a href="detail-pesanan.php?id=<?= $data['id_transaksi']; ?>"
                                   class="btn btn-success btn-sm">

                                    <i class="fa fa-eye"></i>
                                    Detail

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <?php }else{ ?>

                <div class="alert alert-warning">

                    <i class="fa fa-exclamation-circle"></i>

                    Belum ada pesanan

                </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>