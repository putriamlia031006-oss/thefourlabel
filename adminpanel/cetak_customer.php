<?php
require "session.php";
require "../koneksi.php";

// Query mengambil semua data customer
$queryCustomer = mysqli_query($koneksi,

    "SELECT * FROM pelanggan
     ORDER BY id_pelanggan ASC"

);

if(!$queryCustomer){
    die("Gagal mengambil data : " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cetak Data Customer</title>

    <link rel="stylesheet"
          href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <style>

        :root{
            --primary-color:#2d3436;
            --accent-color:#0984e3;
            --border-light:#dfe6e9;
            --text-muted:#636e72;
        }

        body{
            background:#f8f9fa;
            font-family:Arial, sans-serif;
            color:var(--primary-color);
        }

        .report-card{
            background:white;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,0.05);
            padding:40px;
            margin:40px auto;
            max-width:1100px;
        }

        .no-print-nav{
            background:white;
            border-radius:12px;
            padding:15px 25px;
            margin:20px auto;
            max-width:1100px;
            border:1px solid var(--border-light);
        }

        .kop-surat{
            display:flex;
            justify-content:space-between;
            align-items:center;
            border-bottom:2px solid #000;
            padding-bottom:20px;
            margin-bottom:30px;
        }

        .brand-name{
            font-size:32px;
            font-weight:bold;
        }

        .brand-info p{
            margin:0;
            font-size:13px;
            text-align:right;
            color:var(--text-muted);
        }

        .table thead th{
            background:#f8f9fa;
            text-transform:uppercase;
            font-size:12px;
            letter-spacing:1px;
            padding:12px;
        }

        .table tbody td{
            padding:12px;
            font-size:14px;
            border-bottom:1px solid var(--border-light);
        }

        .customer-photo{
            width:45px;
            height:45px;
            object-fit:cover;
            border-radius:50%;
        }

        @media print{

            @page{
                size:A4 portrait;
                margin:1cm;
            }

            .no-print{
                display:none;
            }

            body{
                background:white;
            }

            .report-card{
                box-shadow:none;
                margin:0;
                padding:0;
                max-width:100%;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- NAVBAR PRINT -->
    <div class="no-print no-print-nav
                d-flex justify-content-between align-items-center">

        <a href="laporan.php"
           class="btn btn-light">

            ← Kembali

        </a>

        <h6 class="mb-0 text-muted">
            Pratinjau Database Customer
        </h6>

        <button onclick="window.print()"
                class="btn btn-primary">

            Cetak Sekarang

        </button>

    </div>

    <!-- CARD -->
    <div class="report-card">

        <!-- HEADER -->
        <div class="kop-surat">

            <div>

                <h2 class="brand-name mb-0">
                    FASHION GASSSPOL
                </h2>

                <small class="text-uppercase text-muted fw-bold">

                    Customer Database

                </small>

            </div>

            <div class="brand-info">

                <p class="fw-bold text-dark">
                    Tangerang Headquarters
                </p>

                <p>Ruko Fashion Square Kav.12</p>

                <p>Telp : 0838-7123-6672</p>

                <p>info@fashiongassspol.com</p>

            </div>

        </div>

        <!-- TITLE -->
        <div class="text-center mb-4">

            <h4 class="fw-bold text-uppercase">

                Laporan Database Customer

            </h4>

        </div>

        <!-- TABLE -->
        <table class="table align-middle">

            <thead class="text-center">

                <tr>

                    <th width="5%">No</th>

                    <th width="10%">Foto</th>

                    <th class="text-start">
                        Nama Customer
                    </th>

                    <th class="text-start">
                        Email
                    </th>

                    <th width="20%">
                        No HP
                    </th>

                    <th class="text-start">
                        Alamat
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php

            $no = 1;

            if(mysqli_num_rows($queryCustomer) > 0){

                while($data = mysqli_fetch_assoc($queryCustomer)){

            ?>

                <tr>

                    <td class="text-center">

                        <?= $no++; ?>

                    </td>

                    <td class="text-center">

                        <?php

                        if(!empty($data['foto_profile'])){

                            echo "

                            <img
                                src='../uploads/".$data['foto_profile']."'
                                class='customer-photo'
                            >

                            ";

                        } else {

                            echo "

                            <img
                                src='../image/default-profile.png'
                                class='customer-photo'
                            >

                            ";

                        }

                        ?>

                    </td>

                    <td class="fw-semibold">

                        <?= $data['nama_pelanggan']; ?>

                    </td>

                    <td class="text-muted">

                        <?= $data['email_pelanggan']; ?>

                    </td>

                    <td class="text-center">

                        <?= $data['telepon_pelanggan']; ?>

                    </td>

                    <td>

                        <?= $data['alamat_pelanggan']; ?>

                    </td>

                </tr>

            <?php

                }

            } else {

                echo "

                <tr>

                    <td colspan='6'
                        class='text-center py-4'>

                        Data customer belum tersedia

                    </td>

                </tr>

                ";

            }

            ?>

            </tbody>

        </table>

        <!-- FOOTER -->
        <div class="row mt-5 pt-4 d-none d-print-flex justify-content-between">

            <div class="col-8">

                <small class="text-muted">

                    * Laporan customer dicetak otomatis pada

                    <?= date('d/m/Y H:i'); ?>

                </small>

            </div>

            <div class="col-4 text-center">

                <p>
                    Tangerang,
                    <?= date('d F Y'); ?>
                </p>

                <br><br><br>

                <p class="fw-bold">
                    ( Fashion Gassspol Admin )
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>