<?php
require "session.php";
require "../koneksi.php";

// Query JOIN untuk mengambil nama customer dari tbl_customer
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
    <title>Manajemen Transaksi | Fashion Gassspol</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    
    <style>
        /* 2. SET FONT KE SELURUH BODY */
        body {
            background: #f4f7fe;
            font-family: 'Poppins', sans-serif; /* Font jadi cakep & modern */
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

        /* Styling Header Tabel agar Biru Cakep */
        .table thead {
            background-color: #3674B5;
            color: white;
        }

        .table thead th {
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #f1f1f1;
        }

        /* Custom warna badge status */
        .badge {
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        .bg-pending { background-color: #0d6efd; color: #fff; } 
        .bg-proses { background-color: #ffc107; color: #000; }  
        .bg-selesai { background-color: #198754; color: #fff; } 
        .bg-batal { background-color: #dc3545; color: #fff; }

        /* Hover Effect pada baris tabel */
        .table-hover tbody tr:hover {
            background-color: #f9fbff;
            transition: 0.3s;
        }

        .btn-warning {
            color: #fff;
            background-color: #f39c12;
            border: none;
        }
        .btn-warning:hover {
            background-color: #e67e22;
            color: #fff;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title" style="color: #2C3E50; font-weight: 700; display: flex; align-items: center; gap: 15px;">
        <i class="fas fa-file-invoice-dollar" style="color: #004edfff;"></i>Manajemen Transaksi
    </h2>    

    </div>

    <div class="table-container">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($jumlahTransaksi == 0){
                echo '<tr><td colspan="7" class="text-center py-5 text-muted">Belum ada transaksi</td></tr>';
            } else {
                $no = 1;
                while($t = mysqli_fetch_assoc($queryTransaksi)){
                    
                    $status = $t['status_transaksi'];
                    $warna_badge = "bg-secondary"; 

                    if($status == 'Pending'){
                        $warna_badge = "bg-pending"; 
                    } elseif($status == 'Proses'){
                        $warna_badge = "bg-proses";  
                    } elseif($status == 'Selesai'){
                        $warna_badge = "bg-selesai"; 
                    } elseif($status == 'Dibatalkan'){
                        $warna_badge = "bg-batal";   
                    }
            ?>
                <tr>
                    <td class="text-center text-muted"><?= $no++; ?></td>
                    <td class="fw-semibold"><?= $t['nama_pelanggan']; ?></td>
                    <td><?= date('d M Y', strtotime($t['tanggal_transaksi'])); ?></td>
                    <td><span class="badge bg-light text-dark border"><?= $t['total_produk']; ?> Item</span></td>
                    <td class="fw-bold text-success">Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?></td>
                    <td class="text-center">
                        <span class="badge <?= $warna_badge; ?>">
                            <?= $status; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="edit_transaksi.php?id=<?= $t['id_transaksi']; ?>" class="btn btn-sm btn-warning shadow-sm" title="Edit Transaksi">
                            <i class="fas fa-edit"></i> Edittt
                        </a>
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>