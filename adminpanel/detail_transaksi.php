<?php
require "session.php";
require "../koneksi.php";

$querySemuaDetail = mysqli_query($koneksi, "
    SELECT 
        dt.id_detail, 
        dt.id_transaksi, 
        dt.jumlah, 
        p.nama as nama_produk, 
        p.harga, 
        t.tanggal_transaksi
    FROM tbl_detail_transaksi dt
    JOIN tbl_produk p ON dt.id_produk = p.id
    JOIN tbl_transaksi t ON dt.id_transaksi = t.id_transaksi
    ORDER BY dt.id_transaksi DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan | Fashion Gassspol</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    
    <style>
        /* 2. SET FONT & BG - Sama dengan Transaksi */
        body { 
            background: #f4f7fe; 
            font-family: 'Poppins', sans-serif; 
            color: #333;
        }

        h2 {
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }

        .table-container {
            background: #fff; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            border: none;
        }

        /* Styling Header Tabel Biru (Identik dengan halaman Transaksi) */
        .table thead {
            background-color: #3674B5;
            color: white;
        }

        .table thead th {
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: none; /* Menghilangkan Uppercase agar lebih santai */
            font-size: 0.95rem;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #f1f1f1;
        }

        /* Badge untuk ID Transaksi */
        .badge-trx {
            background: #e0e7ff;
            color: #4338ca;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .subtotal-text {
            color: #198754; /* Hijau sukses */
            font-weight: 700;
        }

        /* Footer untuk Grand Total */
        .footer-total {
            background-color: #f8fafc;
            border-top: 2px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: #f9fbff;
            transition: 0.3s;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-boxes me-2 text-primary"></i> Detail Penjualan Produk</h2>

    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1; $grand_total = 0;
                if (mysqli_num_rows($querySemuaDetail) > 0) {
                    while ($item = mysqli_fetch_assoc($querySemuaDetail)) {
                        $subtotal = $item['harga'] * $item['jumlah'];
                        $grand_total += $subtotal;
                ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++; ?></td>
                        <td><span class="badge badge-trx">TRX-<?= $item['id_transaksi']; ?></span></td>
                        <td class="text-muted"><i class="far fa-calendar-alt me-2"></i><?= date('d/m/Y', strtotime($item['tanggal_transaksi'])); ?></td>
                        <td class="fw-semibold"><?= $item['nama_produk']; ?></td>
                        <td class="text-center"><span class="badge bg-light text-dark border"><?= $item['jumlah']; ?></span></td>
                        <td class="text-end">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td class="text-end subtotal-text">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                <?php } } else { ?>
                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data detail transaksi.</td></tr>
                <?php } ?>
                </tbody>
                <tfoot class="footer-total">
                    <tr>
                        <th colspan="6" class="text-end py-4 text-uppercase">Total Omset Seluruh Produk</th>
                        <th class="text-end text-primary fs-5 fw-bold">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>