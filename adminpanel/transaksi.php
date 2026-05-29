<?php
require "session.php";
require "../koneksi.php";

// Query JOIN untuk mengambil nama customer dari tabel pelanggan
$queryTransaksi = mysqli_query($koneksi, "
    SELECT t.*, p.nama_pelanggan
    FROM tbl_transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    ORDER BY t.id_transaksi DESC
");

$jumlahTransaksi = mysqli_num_rows($queryTransaksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi | The Four Label</title>
    
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
            position: relative;
            z-index: 2;
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

        .customer-name {
            font-weight: 800;
            color: var(--primary-dark);
        }

        .item-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 7px 12px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 12px;
            border: none;
        }

        .price-text {
            font-weight: 800;
            color: #15803d;
        }

        .badge-status {
            font-weight: 800;
            padding: 8px 13px;
            border-radius: 50px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .bg-pending {
            background-color: #dbeafe;
            color: #1d4ed8;
        } 

        .bg-proses {
            background-color: #fef3c7;
            color: #92400e;
        }  

        .bg-selesai {
            background-color: #dcfce7;
            color: #166534;
        } 

        .bg-batal {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .bg-lainnya {
            background-color: #e5e7eb;
            color: #374151;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            border: none;
            padding: 9px 14px;
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.22);
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
                <i class="fas fa-file-invoice-dollar me-2"></i> Manajemen Transaksi
            </h2>

            <p class="page-desc">
                Kelola transaksi pesanan customer, jumlah item, total harga, dan status proses pesanan konveksi.
            </p>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="table-title">
                <i class="fas fa-list me-2"></i>Daftar Transaksi
            </h5>
            <p class="table-subtitle">
                Total transaksi tercatat: <?= $jumlahTransaksi; ?> data
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70px;">No</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                if($jumlahTransaksi == 0){
                    echo '<tr><td colspan="7" class="text-center empty-state"><i class="fas fa-folder-open me-2"></i>Belum ada transaksi</td></tr>';
                } else {
                    $no = 1;
                    while($t = mysqli_fetch_assoc($queryTransaksi)){
                        
                        $status = $t['status_transaksi'];
                        $status_lower = strtolower($status);

                        $warna_badge = "bg-lainnya"; 
                        $icon_status = "fas fa-circle";
                        $status_tampil = ucfirst($status_lower);

                        if($status_lower == 'pending'){
                            $warna_badge = "bg-pending";
                            $icon_status = "fas fa-clock";
                            $status_tampil = "Pending";
                        } elseif($status_lower == 'proses'){
                            $warna_badge = "bg-proses";
                            $icon_status = "fas fa-spinner";
                            $status_tampil = "Proses";
                        } elseif($status_lower == 'selesai'){
                            $warna_badge = "bg-selesai";
                            $icon_status = "fas fa-check-circle";
                            $status_tampil = "Selesai";
                        } elseif($status_lower == 'dibatalkan'){
                            $warna_badge = "bg-batal";
                            $icon_status = "fas fa-times-circle";
                            $status_tampil = "Dibatalkan";
                        }
                ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $no++; ?></td>

                        <td class="customer-name">
                            <?= $t['nama_pelanggan']; ?>
                        </td>

                        <td>
                            <?= date('d M Y', strtotime($t['tanggal_transaksi'])); ?>
                        </td>

                        <td>
                            <span class="item-badge">
                                <i class="fas fa-box"></i>
                                <?= $t['total_produk']; ?> Item
                            </span>
                        </td>

                        <td class="price-text">
                            Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?>
                        </td>

                        <td class="text-center">
                            <span class="badge-status <?= $warna_badge; ?>">
                                <i class="<?= $icon_status; ?>"></i>
                                <?= $status_tampil; ?>
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="edit_transaksi.php?id=<?= $t['id_transaksi']; ?>" class="btn-action" title="Edit Transaksi">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>

</body>
</html>