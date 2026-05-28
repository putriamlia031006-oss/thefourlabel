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

        case 'pending':
            return 'status-pending';

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
    <title>Cetak Rekap Transaksi | The Four Label</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-light: #a78bfa;
            --primary-soft: #ede9fe;
            --bg-body: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
        }

        *{
            box-sizing: border-box;
        }

        body{
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.18), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .report-card{
            background: rgba(255, 255, 255, 0.95);
            border-radius: 26px;
            padding: 42px;
            margin: 40px auto;
            max-width: 1120px;
            box-shadow: 0 14px 32px rgba(76, 29, 149, 0.10);
            border: 1px solid rgba(124, 58, 237, 0.10);
            overflow: hidden;
            position: relative;
        }

        .report-card::before{
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
        }

        .btn-back{
            background: #ede9fe;
            color: var(--primary-dark);
            border: none;
            border-radius: 13px;
            padding: 10px 18px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-back:hover{
            background: #ddd6fe;
            color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-print{
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 13px;
            padding: 10px 20px;
            font-weight: 700;
            transition: 0.3s;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-print:hover{
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            color: white;
            transform: translateY(-1px);
        }

        .report-brand h2{
            color: var(--primary-dark);
            font-weight: 800;
            letter-spacing: 1px;
        }

        .report-brand small,
        .company-info small{
            color: var(--text-muted);
            font-weight: 500;
        }

        .report-title{
            color: var(--primary-dark);
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .report-subtitle{
            color: var(--text-muted);
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 25px;
        }

        .table{
            border-color: rgba(124, 58, 237, 0.16);
        }

        .table thead th{
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%) !important;
            color: white !important;
            border: none;
            padding: 14px 12px;
            font-size: 13px;
            font-weight: 700;
            vertical-align: middle;
        }

        .table tbody td{
            padding: 13px 12px;
            font-size: 13px;
            vertical-align: middle;
            border-color: rgba(124, 58, 237, 0.12);
        }

        .table tbody tr:nth-child(even){
            background-color: #faf5ff;
        }

        .status-badge{
            font-size: 12px;
            padding: 7px 12px;
            border-radius: 50px;
            font-weight: 800;
            display: inline-block;
        }

        .status-selesai{
            background:#dcfce7;
            color:#166534;
        }

        .status-proses{
            background:#fef3c7;
            color:#92400e;
        }

        .status-pending{
            background:#dbeafe;
            color:#1d4ed8;
        }

        .status-batal{
            background:#fee2e2;
            color:#991b1b;
        }

        .status-default{
            background:#e5e7eb;
            color:#374151;
        }

        tfoot tr{
            background: #ede9fe;
        }

        tfoot td{
            color: var(--primary-dark);
            border-color: rgba(124, 58, 237, 0.16) !important;
            padding: 16px 12px !important;
        }

        .grand-total{
            color: var(--primary) !important;
            font-size: 18px;
            font-weight: 800;
        }

        .signature-box{
            color: var(--text-dark);
            font-size: 14px;
        }

        .print-date{
            color: var(--text-muted);
            font-size: 13px;
        }

        @media print{

            .no-print{
                display:none !important;
            }

            body{
                background:white !important;
                color:#000;
            }

            .container{
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .report-card{
                box-shadow:none;
                margin:0;
                max-width:100%;
                border-radius:0;
                border:none;
                padding: 22px;
            }

            .report-card::before{
                height: 6px;
            }

            .table thead th{
                background: #7c3aed !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status-badge,
            tfoot tr,
            .table tbody tr:nth-child(even){
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <div class="no-print d-flex justify-content-between align-items-center my-4">

        <a href="laporan.php" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>

        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print me-2"></i> Cetak
        </button>

    </div>

    <div class="report-card">

        <div class="d-flex justify-content-between mb-4 border-bottom pb-3">

            <div class="report-brand">
                <h2 class="mb-0">
                    THE FOUR LABEL
                </h2>

                <small>
                    Konveksi & Fashion Production
                </small>
            </div>

            <div class="text-end company-info">

                <small>
                    Tangerang Headquarters
                    <br>
                    Telp: 0838-7123-6672
                    <br>
                    info@thefourlabel.com
                </small>

            </div>

        </div>

        <h4 class="text-center report-title mb-3">
            LAPORAN REKAP TRANSAKSI
        </h4>

        <p class="text-center report-subtitle">
            Rekap data transaksi pesanan customer The Four Label
        </p>

        <table class="table table-bordered align-middle">

            <thead class="text-center">
                <tr>
                    <th style="width: 60px;">No</th>
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

                    <td class="fw-semibold">
                        <?= $data['nama_pelanggan']; ?>
                    </td>

                    <td class="text-center">
                        <?= date(
                            'd/m/Y',
                            strtotime($data['tanggal_transaksi'])
                        ); ?>
                    </td>

                    <td class="text-center">
                        <?= $data['total_produk']; ?> Item
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
                    <td colspan='6' class='text-center py-4'>
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

                    <td colspan="2" class="text-end grand-total">
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
                <small class="print-date">
                    Dicetak pada:
                    <?= date('d/m/Y H:i'); ?>
                </small>
            </div>

            <div class="text-center signature-box">

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