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
    <title>Manajemen Customer | The Four Label</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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

        .custom-card,
        .table-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.09);
            position: relative;
            overflow: hidden;
        }

        .custom-card::after,
        .table-container::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.06);
            top: -48px;
            right: -48px;
        }

        .card-content,
        .table-content {
            position: relative;
            z-index: 2;
        }

        .form-title,
        .table-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-size: 21px;
        }

        .form-subtitle,
        .table-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 24px;
        }

        label {
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 16px;
            background-color: #fbfaff;
            border: 1px solid rgba(124, 58, 237, 0.12);
            color: var(--text-dark);
            font-weight: 500;
            transition: 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.13) !important;
            border-color: var(--primary);
            background-color: #fff;
        }

        textarea.form-control {
            resize: none;
        }

        .btn-custom {
            border-radius: 14px;
            padding: 13px 25px;
            font-weight: 800;
            transition: 0.3s;
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            border: none;
            color: white;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 10px 22px rgba(76, 29, 149, 0.25);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
        }

        .table thead th {
            padding: 17px 18px;
            border: none;
            font-size: 14px;
            font-weight: 700;
        }

        .table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(124, 58, 237, 0.07);
            color: var(--text-dark);
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #faf5ff;
        }

        .cust-name {
            font-weight: 800;
            color: var(--primary-dark);
        }

        .email-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 7px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 12px;
        }

        .phone-text {
            color: var(--text-muted);
            font-weight: 600;
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

        .col-aksi {
            white-space: nowrap;
        }

        .empty-state {
            padding: 55px 20px !important;
            color: var(--text-muted);
            font-weight: 600;
        }

        .alert {
            border-radius: 15px;
            border: none;
            font-weight: 600;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 28px 24px;
                border-radius: 24px;
            }

            .page-title {
                font-size: 25px;
            }

            .custom-card,
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
                <i class="fas fa-user-friends me-2"></i> Manajemen Customer
            </h2>

            <p class="page-desc">
                Kelola data pelanggan konveksi, mulai dari nama, email, nomor HP, hingga alamat customer.
            </p>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-content">
                    <h5 class="form-title">
                        <i class="fas fa-user-plus me-2"></i>Tambah Customer
                    </h5>

                    <p class="form-subtitle">
                        Masukkan data customer baru.
                    </p>

                    <form method="post">

                        <div class="mb-3">
                            <label>Nama Customer</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Cindy Setio" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat customer"></textarea>
                        </div>

                        <button type="submit" name="simpan_customer" class="btn btn-custom w-100">
                            <i class="fas fa-save me-2"></i> Simpan Customer
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
        </div>

        <div class="col-lg-8">
            <div class="table-container">
                <div class="table-content">
                    <h5 class="table-title">
                        <i class="fas fa-list me-2"></i>Daftar Customer
                    </h5>

                    <p class="table-subtitle">
                        Total customer terdaftar: <?= $jumlahcustomer; ?> data
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead>
                                <tr>
                                    <th style="width: 70px;">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if($jumlahcustomer == 0){ ?>

                                <tr>
                                    <td colspan="5" class="text-center empty-state">
                                        <i class="fas fa-folder-open me-2"></i>Belum ada data customer
                                    </td>
                                </tr>

                            <?php } else { ?>

                                <?php
                                $no = 1;

                                while($data = mysqli_fetch_array($querycustomer)){
                                ?>

                                <tr>

                                    <td class="fw-bold"><?= $no++; ?></td>

                                    <td class="cust-name">
                                        <?= $data['nama_pelanggan']; ?>
                                    </td>

                                    <td>
                                        <span class="email-badge">
                                            <i class="fas fa-envelope"></i>
                                            <?= $data['email_pelanggan']; ?>
                                        </span>
                                    </td>

                                    <td class="phone-text">
                                        <?= $data['telepon_pelanggan']; ?>
                                    </td>

                                    <td class="col-aksi text-center">

                                        <a href="customer-detail.php?id=<?= $data['id_pelanggan']; ?>"
                                           class="btn-action">

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

</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>

</body>
</html>