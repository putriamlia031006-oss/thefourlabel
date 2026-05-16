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
    <title>Kelola Kategori | Fashion Gassspol</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3674B5;
            --dark-blue: #234e7a;
            --bg-body: #f4f7fe;
        }

        /* --- FIX NAVBAR BERGESER (TOTAL FIX) --- */
        html {
            overflow-y: scroll; /* Memaksa scrollbar vertikal selalu ada */
            scrollbar-gutter: stable; /* Menjaga ruang layout tetap stabil */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: #333;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* --- Estetika Halaman --- */
        .no-decoration { text-decoration: none; }
        
        .breadcrumb { background: transparent; padding: 0; }
        .breadcrumb-item i { margin-right: 8px; color: var(--primary-color); }
        
        .page-title { 
            font-weight: 700; 
            color: var(--dark-blue); 
            margin-bottom: 30px; 
        }

        /* --- Card & Form Styling --- */
        .custom-card {
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-label { font-weight: 600; color: #555; font-size: 14px; }
        
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
            transition: 0.3s;
        }

        .form-control:focus {
            box-shadow: none !important;
            border-color: var(--primary-color);
            background-color: #fff;
        }

        .btn-custom {
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: 0.3s;
            background-color: var(--primary-color);
            border: none;
        }

        .btn-custom:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }

        /* --- Table Styling --- */
        .table-container {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .table { margin-bottom: 0; }
        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table thead th {
            padding: 18px 20px;
            font-weight: 500;
            border: none;
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f2f2f2;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: 0.3s;
            background-color: #eef5ff;
            color: var(--primary-color);
        }

        .btn-action:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        /* Alert Styling */
        .alert { border-radius: 15px; border: none; font-weight: 500; }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">

<h2 class="page-title" style="color: #2C3E50; font-weight: 700;">
    <i class="fas fa-box-open" style="color: #004edfff;"></i> Manajemen Kategori
</h2>

        <div class="row">
            <div class="col-lg-5">
                <div class="custom-card">
                    <h4 class="mb-4 fw-bold"><i class="fas fa-plus-circle text-primary me-2"></i>Tambah Kategori</h4>
                    
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="kategori" id="kategori" placeholder="Input nama kategori..." class="form-control" required autocomplete="off">
                        </div>
                        <button class="btn btn-primary btn-custom w-100" type="submit" name="simpan_kategori">
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
                                    echo '<div class="alert alert-success mt-3"><i class="fas fa-check-circle me-2"></i> Berhasil disimpan!</div>';
                                    echo '<meta http-equiv="refresh" content="1; url=kategori.php" />';
                                } else {
                                    echo '<div class="alert alert-danger mt-3">' . mysqli_error($koneksi) . '</div>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($jumlahkategori == 0){
                                    echo '<tr><td colspan="3" class="text-center text-muted py-5">Belum ada data kategori</td></tr>';
                                } else {
                                    $no = 1;
                                    while($data = mysqli_fetch_array($querikategori)){
                            ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td class="fw-medium"><?php echo $data['nama']; ?></td>
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

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>