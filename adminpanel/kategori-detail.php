<?php   
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE id_kategori='$id'");
    $data = mysqli_fetch_array($query);
    
    // Proteksi jika ID tidak ditemukan di database
    if(mysqli_num_rows($query) == 0){
        header('location: kategori.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori | Fashion Gassspol</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3674B5;
            --dark-blue: #234e7a;
            --bg-body: #f4f7fe;
        }

        /* --- FIX NAVBAR BERGESER --- */
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: #333;
        }

        .no-decoration { text-decoration: none; }
        
        .page-title { 
            font-weight: 700; 
            color: var(--dark-blue); 
            margin-bottom: 20px; 
        }

        /* --- Card Styling --- */
        .custom-card {
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 20px;
        }

        .form-label { font-weight: 600; color: #555; }
        
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: none !important;
            border-color: var(--primary-color);
            background-color: #fff;
        }

        /* --- Button Styling --- */
        .btn-custom {
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .alert { border-radius: 15px; border: none; font-weight: 500; }
    </style>
</head>
<body>
    <?php require "navbar.php" ?>
    
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="kategori.php" class="no-decoration text-muted">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Kategori</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-6">
                <div class="custom-card">
                    <h2 class="page-title text-center mb-4">Edit Kategori</h2>
                    
                    <form action="" method="post">
                        <div class="mb-4">
                            <label for="kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama'];?>" autocomplete="off" required>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <button type="submit" class="btn btn-primary btn-custom" name="editbtn">
                                <i class="fas fa-save me-2"></i> Update
                            </button>
                            <button type="submit" class="btn btn-danger btn-custom" name="deletebtn">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                    <?php
                        // --- LOGIKA EDIT (FIX CASE SENSITIVE) ---
                        if(isset($_POST['editbtn'])){
                            $kategori = htmlspecialchars($_POST['kategori']);

                            // Cek apakah input baru benar-benar sama persis (termasuk besar kecilnya) dengan di DB
                            if($data['nama'] === $kategori){
                                echo '<meta http-equiv="refresh" content="0; url=kategori.php" />';
                            } else {
                                // Menggunakan BINARY untuk membedakan 'hoodie' dan 'Hoodie'
                                $queryCheck = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE BINARY nama='$kategori'");
                                $jumlahdata = mysqli_num_rows($queryCheck);

                                if($jumlahdata > 0){
                                    echo '<div class="alert alert-warning"><i class="fas fa-exclamation-circle me-2"></i> Kategori "'.$kategori.'" sudah ada!</div>';
                                } else {
                                    $queryUpdate = mysqli_query($koneksi, "UPDATE tbl_kategori SET nama='$kategori' WHERE id_kategori='$id'");
                                    if($queryUpdate){
                                        echo '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> Berhasil diupdate!</div>';
                                        echo '<meta http-equiv="refresh" content="1; url=kategori.php" />';
                                    } else {
                                        echo '<div class="alert alert-danger">'.mysqli_error($koneksi).'</div>';
                                    }
                                }
                            }
                        }

                        // --- LOGIKA HAPUS ---
                        if(isset($_POST['deletebtn'])){
                            $querycheck = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE id_kategori ='$id'");
                            $querycount = mysqli_num_rows($querycheck);

                            if($querycount > 0){
                                echo '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i> Gagal! Kategori ini masih digunakan oleh '.$querycount.' produk.</div>';
                            } else {
                                $querydelete = mysqli_query($koneksi, "DELETE FROM tbl_kategori WHERE id_kategori='$id'");
                                if($querydelete){
                                    echo '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> Kategori berhasil dihapus!</div>';
                                    echo '<meta http-equiv="refresh" content="1; url=kategori.php" />';
                                } else {
                                    echo '<div class="alert alert-danger">'.mysqli_error($koneksi).'</div>';
                                }
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>