<?php
require "session.php";
require "../koneksi.php";

// Query mengambil data transaksi
$queryTransaksi = mysqli_query($koneksi, "

    SELECT
        t.*,
        p.nama_pelanggan

    FROM tbl_transaksi t

    JOIN pelanggan p
    ON t.id_pelanggan = p.id_pelanggan

    ORDER BY t.tanggal_transaksi DESC

");

if(!$queryTransaksi){
    die("Query Gagal : " . mysqli_error($koneksi));
}

// Fungsi menentukan warna status
function getStatusStyle($status){

    $status = strtolower($status);

    switch($status){

        case 'selesai':
            return 'status-selesai';

        case 'proses':
            return 'status-proses';

        case 'dibatalkan':
            return 'status-batal';

        default:
            return 'status-default';

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Rekap Transaksi</title>

    <link rel="stylesheet"
          href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <style>

        body{
            background:#f8f9fa;
            font-family:Arial, sans-serif;
        }

        .report-card{
            background:white;
            border-radius:16px;
            padding:40px;
            margin:40px auto;
            max-width:1100px;
            box-shadow:0 10px 30px rgba(0,0,0,0.05);
        }

        .status-badge{
            font-size:12px;
            padding:5px 10px;
            border-radius:8px;
            font-weight:bold;
        }

        .status-selesai{
            background:#d4edda;
            color:#155724;
        }

        .status-proses{
            background:#d1ecf1;
            color:#0c5460;
        }

        .status-batal{
            background:#f8d7da;
            color:#721c24;
        }

        .status-default{
            background:#eee;
            color:#333;
        }

        @media print{

            .no-print{
                display:none;
            }

            body{
                background:white;
            }

            .report-card{
                box-shadow:none;
                margin:0;
                max-width:100%;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="no-print d-flex justify-content-between align-items-center my-4">

        <a href="laporan.php"
           class="btn btn-secondary">
            Kembali
        </a>

        <button onclick="window.print()"
                class="btn btn-primary">
            Cetak
        </button>

    </div>

    <div class="report-card">

        <div class="d-flex justify-content-between mb-4 border-bottom pb-3">

            <div>
                <h2 class="fw-bold mb-0">
                    FASHION GASSSPOL
                </h2>

                <small class="text-muted">
                    Transaction Report
                </small>
            </div>

            <div class="text-end">

                <small>
                    Tangerang Headquarters
                    <br>
                    Telp: 0838-7123-6672
                    <br>
                    info@fashiongassspol.com
                </small>

            </div>

        </div>

        <h4 class="text-center fw-bold mb-4">
            LAPORAN REKAP TRANSAKSI
        </h4>

        <table class="table table-bordered align-middle">

            <thead class="table-light text-center">

                <tr>

                    <th>No</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $no = 1;
            $grand_total = 0;

            if(mysqli_num_rows($queryTransaksi) > 0){

                while($data = mysqli_fetch_assoc($queryTransaksi)){

                    $grand_total += $data['total_harga'];

                    $warnaStatus = getStatusStyle(
                        $data['status_transaksi']
                    );

            ?>

                <tr>

                    <td class="text-center">
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= $data['nama_pelanggan']; ?>
                    </td>

                    <td class="text-center">

                        <?= date(
                            'd/m/Y',
                            strtotime($data['tanggal_transaksi'])
                        ); ?>

                    </td>

                    <td class="text-center">
                        <?= $data['total_produk']; ?>
                    </td>

                    <td class="text-end fw-bold">

                        Rp <?= number_format(
                            $data['total_harga'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>

                    <td class="text-center">

                        <span class="status-badge <?= $warnaStatus; ?>">

                            <?= $data['status_transaksi']; ?>

                        </span>

                    </td>

                </tr>

            <?php

                }

            } else {

                echo "

                <tr>

                    <td colspan='6' class='text-center'>
                        Belum ada data transaksi
                    </td>

                </tr>

                ";

            }

            ?>

            </tbody>

            <tfoot>

                <tr class="fw-bold">

                    <td colspan="4" class="text-end">
                        Grand Total
                    </td>

                    <td colspan="2" class="text-end text-primary">

                        Rp <?= number_format(
                            $grand_total,
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>

                </tr>

            </tfoot>

        </table>

        <div class="mt-5 d-flex justify-content-between">

            <div>

                <small class="text-muted">

                    Dicetak pada:
                    <?= date('d/m/Y H:i'); ?>

                </small>

            </div>

            <div class="text-center">

                <p>
                    Tangerang,
                    <?= date('d F Y'); ?>
                </p>

                <br><br><br>

                <p>
                    (...........................)
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>