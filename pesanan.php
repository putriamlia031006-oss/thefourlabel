<?php

session_start();

require "koneksi.php";

// =========================
// VALIDASI SESSION
// =========================

if(!isset($_SESSION['last_id'])){

    echo "

    <script>

    alert('Selesaikan pesanan terlebih dahulu');

    location='produk.php';

    </script>

    ";

    exit;

}

$id_transaksi = $_SESSION['last_id'];

// =========================
// QUERY TRANSAKSI
// =========================

$query = "

SELECT

    t.*,
    p.nama_pelanggan,
    p.email_pelanggan,
    p.telepon_pelanggan,
    p.alamat_pelanggan

FROM tbl_transaksi t

JOIN pelanggan p
ON t.id_pelanggan = p.id_pelanggan

WHERE t.id_transaksi = '$id_transaksi'

";

$ambil = mysqli_query($koneksi, $query);

$pecah = mysqli_fetch_assoc($ambil);

// =========================
// VALIDASI DATA
// =========================

if(!$pecah){

    echo "

    <script>

    alert('Data transaksi tidak ditemukan');

    location='produk.php';

    </script>

    ";

    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Status Pesanan | Fashion Gassspol
    </title>

    <link rel="stylesheet"
          href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="fontawesome/css/all.min.css">

    <style>

        body{
            background:#f5f6fa;
        }

        .card-order{
            border:none;
            border-radius:18px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        .status-badge{
            background:#fff3cd;
            color:#856404;
            padding:7px 18px;
            border-radius:50px;
            font-weight:bold;
            display:inline-block;
        }

        .section-title{
            font-size:14px;
            font-weight:bold;
            color:#198754;
            margin-bottom:10px;
            border-bottom:2px solid #f0f0f0;
            padding-bottom:5px;
        }

        .table thead th{
            background:#f8f9fa;
            text-transform:uppercase;
            font-size:12px;
        }

        .product-name{
            font-weight:600;
            color:#212529;
        }

        .total-row{
            background:#fafafa;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark mb-4">

    <div class="container">

        <a class="navbar-brand fw-bold text-success"
           href="index.php">

            FASHION
            <span class="text-white">
                GASSSPOL
            </span>

        </a>

    </div>

</nav>

<!-- CONTENT -->
<div class="container py-4">

    <!-- TITLE -->
    <div class="text-center mb-5">

        <h2 class="fw-bold">

            Terima Kasih,
            <?= $pecah['nama_pelanggan']; ?> !

        </h2>

        <p class="text-muted">

            Pesanan Anda telah kami terima

        </p>

    </div>

    <!-- CARD -->
    <div class="card card-order mx-auto"
         style="max-width:900px;">

        <div class="card-body p-4">

            <!-- HEADER -->
            <div class="row mb-4">

                <div class="col-6">

                    <small class="text-muted">
                        NO. TRANSAKSI
                    </small>

                    <h5 class="fw-bold text-primary">

                        #TRX-<?= $pecah['id_transaksi']; ?>

                    </h5>

                </div>

                <div class="col-6 text-end">

                    <small class="text-muted">
                        TANGGAL
                    </small>

                    <h5 class="fw-bold">

                        <?= date(
                            "d F Y",
                            strtotime(
                                $pecah['tanggal_transaksi']
                            )
                        ); ?>

                    </h5>

                </div>

            </div>

            <!-- CUSTOMER -->
            <div class="row mb-4">

                <div class="col-md-6">

                    <div class="section-title">
                        Informasi Pelanggan
                    </div>

                    <p class="mb-1 text-secondary small">
                        Nama Lengkap
                    </p>

                    <p class="fw-bold">

                        <?= $pecah['nama_pelanggan']; ?>

                    </p>

                    <p class="mb-1 text-secondary small">
                        Kontak
                    </p>

                    <p class="fw-bold mb-1">

                        <?= $pecah['email_pelanggan']; ?>

                    </p>

                    <p class="fw-bold mb-1">

                        <?= $pecah['telepon_pelanggan']; ?>

                    </p>

                    <p class="text-muted">

                        <?= $pecah['alamat_pelanggan']; ?>

                    </p>

                </div>

                <!-- STATUS -->
                <div class="col-md-6 text-md-end">

                    <div class="section-title">
                        Status Pesanan
                    </div>

                    <span class="status-badge">

                        <?= $pecah['status_transaksi']; ?>

                    </span>

                </div>

            </div>

            <!-- TABLE -->
            <div class="section-title">
                Rincian Produk
            </div>

            <div class="table-responsive mb-4">

                <table class="table table-hover border">

                    <thead>

                        <tr>

                            <th class="px-3 py-3">
                                Produk
                            </th>

                            <th class="text-center py-3">
                                Qty
                            </th>

                            <th class="text-end py-3">
                                Harga
                            </th>

                            <th class="text-end px-3 py-3">
                                Subtotal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $queryDetail = "

                    SELECT

                        dt.*,
                        p.nama,
                        p.harga

                    FROM tbl_detail_transaksi dt

                    JOIN tbl_produk p
                    ON dt.id_produk = p.id

                    WHERE dt.id_transaksi = '$id_transaksi'

                    ";

                    $ambilDetail = mysqli_query(
                        $koneksi,
                        $queryDetail
                    );

                    while($item = mysqli_fetch_assoc($ambilDetail)):

                        $subtotal =
                            $item['harga']
                            *
                            $item['jumlah'];

                    ?>

                        <tr>

                            <td class="product-name px-3 py-3">

                                <?= $item['nama']; ?>

                            </td>

                            <td class="text-center py-3">

                                <?= $item['jumlah']; ?>

                            </td>

                            <td class="text-end py-3">

                                Rp <?= number_format(
                                    $item['harga'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </td>

                            <td class="text-end px-3 py-3 fw-bold">

                                Rp <?= number_format(
                                    $subtotal,
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                    <tfoot>

                        <tr class="total-row">

                            <th colspan="3"
                                class="text-end py-3">

                                Total Bayar

                            </th>

                            <th class="text-end
                                       text-success
                                       fs-5
                                       px-3
                                       py-3">

                                Rp <?= number_format(
                                    $pecah['total_harga'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

            <!-- BUTTON -->
            <div class="d-grid">

                <a href="index.php"
                   class="btn btn-success
                          p-3 fw-bold shadow-sm">

                    Kembali ke Beranda

                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>