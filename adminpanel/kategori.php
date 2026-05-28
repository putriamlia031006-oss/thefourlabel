<?php   
    require "session.php";
    require "../koneksi.php";

    $querikategori = mysqli_query($koneksi,"SELECT * FROM tbl_kategori");
    $jumlahkategori = mysqli_num_rows($querikategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori | The Four Label</title>

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
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
        }

        .no-decoration {
            text-decoration: none;
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

        .custom-card {
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(124, 58, 237, 0.09);
            border-radius: 26px;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .custom-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.07);
            top: -42px;
            right: -42px;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        .form-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 22px;
            font-size: 20px;
        }

        .form-title i {
            color: var(--primary);
        }

        .form-label {
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 14px;
            padding: 13px 16px;
            border: 1px solid rgba(124, 58, 237, 0.12);
            background-color: #fbfaff;
            transition: 0.3s;
            color: var(--text-dark);
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #a1a1aa;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.13) !important;
            border-color: var(--primary);
            background-color: #fff;
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

        .table-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.09);
        }

        .table-header {
            padding: 24px 26px 16px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        }

        .table-header h4 {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .table-header p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 14px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            color: white;
        }

        .table thead th {
            padding: 17px 20px;
            font-weight: 700;
            border: none;
            font-size: 14px;
        }

        .table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(124, 58, 237, 0.07);
            color: var(--text-dark);
        }

        .table tbody tr:hover {
            background-color: #faf5ff;
        }

        .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 8px 13px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
        }

        .btn-action {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            transition: 0.3s;
            background-color: var(--primary-soft);
            color: var(--primary);
        }

        .btn-action:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.22);
        }

        .alert {
            border-radius: 15px;
            border: none;
            font-weight: 600;
            font-size: 14px;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
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
                    <i class="fas fa-layer-group me-2"></i> Manajemen Kategori
                </h2>

                <p class="page-desc">
                    Kelola kategori produk konveksi seperti kaos, kemeja, jaket, seragam, dan produk lainnya.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="custom-card">
                    <div class="card-content">
                        <h4 class="form-title">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
                        </h4>
                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Nama Kategori</label>
                                <input type="text" name="kategori" id="kategori" placeholder="Contoh: Kaos Custom" class="form-control" required autocomplete="off">
                            </div>

                            <button class="btn btn-custom w-100" type="submit" name="simpan_kategori">
                                <i class="fas fa-save me-2"></i> Simpan Kategori
                            </button>
                        </form>

                        <?php
                            if(isset($_POST['simpan_kategori'])){
                                $kategori = htmlspecialchars($_POST['kategori']);

                                $queryExist = mysqli_query($koneksi, "SELECT nama FROM tbl_kategori WHERE nama='$kategori'");
                                $jumlahdatabaru = mysqli_num_rows($queryExist);
                                
                                if($jumlahdatabaru > 0){
                                    echo '<div class="alert alert-warning mt-3"><i class="fas fa-exclamation-triangle me-2"></i> Kategori sudah ada!</div>';
                                } else {
                                    $querysimpan = mysqli_query($koneksi, "INSERT INTO tbl_kategori (nama) VALUES ('$kategori')");
                                    if($querysimpan){
                                        echo '<div class="alert alert-success mt-3"><i class="fas fa-check-circle me-2"></i> Kategori berhasil disimpan!</div>';
                                        echo '<meta http-equiv="refresh" content="1; url=kategori.php" />';
                                    } else {
                                        echo '<div class="alert alert-danger mt-3">' . mysqli_error($koneksi) . '</div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="table-container">
                    <div class="table-header">
                        <h4><i class="fas fa-list me-2"></i>Daftar Kategori</h4>
                        <p>Total kategori: <?php echo $jumlahkategori; ?> data</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">No.</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($jumlahkategori == 0){
                                        echo '<tr><td colspan="3" class="text-center empty-state"><i class="fas fa-folder-open me-2"></i>Belum ada data kategori</td></tr>';
                                    } else {
                                        $no = 1;
                                        while($data = mysqli_fetch_array($querikategori)){
                                ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $no; ?></td>
                                            <td>
                                                <span class="category-badge">
                                                    <i class="fas fa-tag"></i>
                                                    <?php echo $data['nama']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="kategori-detail.php?p=<?php echo $data['id_kategori']; ?>" class="btn-action no-decoration" title="Detail">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                        $no++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>