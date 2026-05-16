<?php
require "session.php";
require "../koneksi.php";

// Mengambil data dari database
$querycustomer = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id_pelanggan ASC");
$jumlahcustomer = mysqli_num_rows($querycustomer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Customer | Fashion Gassspol</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <style>
        body{
            background:#f4f7fe;
        }

        .custom-card, .table-container{
            background:white;
            border-radius:20px;
            padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,0.05);
        }

        .cust-name{
            font-weight:bold;
        }

        .col-aksi{
            white-space:nowrap;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">

    <h2 class="fw-bold mb-4">
        <i class="fas fa-user-friends text-primary"></i>
        Manajemen Customer
    </h2>

    <div class="row">

        <!-- FORM TAMBAH -->
        <div class="col-lg-4">
            <div class="custom-card">

                <h5 class="fw-bold mb-4">
                    Tambah Customer
                </h5>

                <form method="post">

                    <div class="mb-3">
                        <label>Nama Customer</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="telepon" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>

                    <button type="submit" name="simpan_customer" class="btn btn-primary w-100">
                        Simpan Customer
                    </button>

                </form>

                <?php

                if(isset($_POST['simpan_customer'])){

                    $nama       = htmlspecialchars($_POST['nama']);
                    $email      = htmlspecialchars($_POST['email']);
                    $password   = md5($_POST['password']);
                    $telepon    = htmlspecialchars($_POST['telepon']);
                    $alamat     = htmlspecialchars($_POST['alamat']);

                    $queryInsert = mysqli_query($koneksi,

                        "INSERT INTO pelanggan
                        (
                            nama_pelanggan,
                            email_pelanggan,
                            password_pelanggan,
                            telepon_pelanggan,
                            alamat_pelanggan
                        )

                        VALUES
                        (
                            '$nama',
                            '$email',
                            '$password',
                            '$telepon',
                            '$alamat'
                        )"

                    );

                    if($queryInsert){

                        echo "
                        <script>
                            alert('Customer berhasil ditambahkan');
                            window.location='customer.php';
                        </script>
                        ";

                    } else {

                        echo "
                        <div class='alert alert-danger mt-3'>
                            ".mysqli_error($koneksi)."
                        </div>
                        ";

                    }

                }

                ?>

            </div>
        </div>

        <!-- TABEL -->
        <div class="col-lg-8">

            <div class="table-container">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if($jumlahcustomer == 0){ ?>

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data customer
                                </td>
                            </tr>

                        <?php } else { ?>

                            <?php
                            $no = 1;

                            while($data = mysqli_fetch_array($querycustomer)){
                            ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td class="cust-name">
                                    <?= $data['nama_pelanggan']; ?>
                                </td>

                                <td>
                                    <?= $data['email_pelanggan']; ?>
                                </td>

                                <td>
                                    <?= $data['telepon_pelanggan']; ?>
                                </td>

                                <td class="col-aksi">

                                    <a href="customer-detail.php?id=<?= $data['id_pelanggan']; ?>"
                                       class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit"></i>
                                        Edit

                                    </a>

                                </td>

                            </tr>

                            <?php } ?>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>