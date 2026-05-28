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
    <title>Detail Penjualan | The Four Label</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    
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

        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.18), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .page-wrapper {
            padding-top: 38px;
            padding-bottom: 70px;
        }

        .page-header {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            border-radius: 30px;
            padding: 32px;
            color: white;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 34px rgba(76, 29, 149, 0.18);
        }

        .page-header::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            top: -95px;
            right: -65px;
        }

        .page-header::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.09);
            bottom: -65px;
            left: 35%;
        }

        .page-header-content {
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

        .page-title {
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-desc {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 15px;
            line-height: 1.7;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.09);
            position: relative;
        }

        .table-header {
            padding: 26px 28px 18px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        }

        .table-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 5px;
            font-size: 21px;
        }

        .table-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
        }

        .table thead th {
            font-weight: 700;
            border: none;
            padding: 17px 18px;
            font-size: 14px;
        }

        .table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(124, 58, 237, 0.07);
            color: var(--text-dark);
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: #faf5ff;
            transition: 0.3s;
        }

        .badge-trx {
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-weight: 800;
            padding: 8px 13px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
        }

        .date-text {
            color: var(--text-muted);
            font-weight: 600;
        }

        .product-name {
            font-weight: 800;
            color: var(--primary-dark);
        }

        .qty-badge {
            background: #f3e8ff;
            color: var(--primary-dark);
            font-weight: 800;
            padding: 7px 12px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
        }

        .price-text {
            font-weight: 700;
            color: var(--text-dark);
        }

        .subtotal-text {
            color: #15803d;
            font-weight: 800;
        }

        .footer-total {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            border-top: 1px solid rgba(124, 58, 237, 0.12);
        }

        .footer-total th {
            padding: 22px 18px !important;
            color: var(--primary-dark);
            font-weight: 800;
        }

        .grand-total {
            color: var(--primary) !important;
            font-size: 20px;
            font-weight: 800;
        }

        .empty-state {
            padding: 55px 20px !important;
            color: var(--text-muted);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 28px 24px;
                border-radius: 24px;
            }

            .page-title {
                font-size: 25px;
            }

            .table-container {
                border-radius: 22px;
            }
        }
    </style>
</head>

<body>

<?php require "navbar.php"; ?>

<div class="container page-wrapper">

    <div class="page-header">
        <div class="page-header-content">
            <div class="brand-badge">
                <i class="fas fa-shirt"></i>
                Konveksi The Four Label
            </div>

            <h2 class="page-title">
                <i class="fas fa-boxes me-2"></i> Detail Penjualan Produk
            </h2>

            <p class="page-desc">
                Pantau rincian produk yang terjual, jumlah item, harga satuan, subtotal, dan total omset seluruh pesanan.
            </p>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="table-title">
                <i class="fas fa-list me-2"></i>Daftar Detail Penjualan
            </h5>
            <p class="table-subtitle">
                Rincian seluruh produk yang masuk dalam transaksi penjualan konveksi.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70px;">No</th>
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
                $no = 1; 
                $grand_total = 0;

                if (mysqli_num_rows($querySemuaDetail) > 0) {
                    while ($item = mysqli_fetch_assoc($querySemuaDetail)) {
                        $subtotal = $item['harga'] * $item['jumlah'];
                        $grand_total += $subtotal;
                ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $no++; ?></td>

                        <td>
                            <span class="badge-trx">
                                <i class="fas fa-receipt"></i>
                                TRX-<?= $item['id_transaksi']; ?>
                            </span>
                        </td>

                        <td class="date-text">
                            <i class="far fa-calendar-alt me-2"></i>
                            <?= date('d/m/Y', strtotime($item['tanggal_transaksi'])); ?>
                        </td>

                        <td class="product-name">
                            <?= $item['nama_produk']; ?>
                        </td>

                        <td class="text-center">
                            <span class="qty-badge">
                                <i class="fas fa-box"></i>
                                <?= $item['jumlah']; ?> Item
                            </span>
                        </td>

                        <td class="text-end price-text">
                            Rp <?= number_format($item['harga'], 0, ',', '.'); ?>
                        </td>

                        <td class="text-end subtotal-text">
                            Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                        </td>
                    </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan="7" class="text-center empty-state">
                            <i class="fas fa-folder-open me-2"></i>Belum ada data detail transaksi
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

                <tfoot class="footer-total">
                    <tr>
                        <th colspan="6" class="text-end text-uppercase">
                            Total Omset Seluruh Produk
                        </th>
                        <th class="text-end grand-total">
                            Rp <?= number_format($grand_total, 0, ',', '.'); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>

</body>
</html>