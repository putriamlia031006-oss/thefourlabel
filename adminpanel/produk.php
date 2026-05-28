<?php   
    require "session.php";
    require "../koneksi.php";

    // Query untuk mengambil data produk beserta nama kategorinya
    $queryproduk = mysqli_query($koneksi,"SELECT a.*, b.nama AS nama_kategori FROM tbl_produk a JOIN tbl_kategori b ON a.id_kategori=b.id_kategori ORDER BY a.id DESC");
    $jumlahproduk = mysqli_num_rows($queryproduk);

    // Query untuk dropdown kategori
    $querykategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori");

    // Fungsi random string untuk nama file foto
    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk | The Four Label</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
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
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(124, 58, 237, 0.09);
            border-radius: 28px;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            padding: 30px;
            margin-bottom: 34px;
            position: relative;
            overflow: hidden;
        }

        .custom-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.07);
            top: -50px;
            right: -50px;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        .form-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 22px;
            font-size: 21px;
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
        
        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 13px 16px;
            background-color: #fbfaff;
            border: 1px solid rgba(124, 58, 237, 0.12);
            color: var(--text-dark);
            font-weight: 500;
            transition: 0.3s;
        }

        .form-control::placeholder {
            color: #a1a1aa;
        }

        .form-control:focus,
        .form-select:focus {
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

        .section-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 6px;
        }

        .section-desc {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.09);
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

        .product-name {
            font-weight: 800;
            color: var(--primary-dark);
        }

        .category-badge {
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

        .price-text {
            color: #15803d;
            font-weight: 800;
        }

        .badge-stok {
            padding: 7px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
        }

        .stok-tersedia {
            background: #dcfce7;
            color: #166534;
        }

        .stok-habis {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background-color: var(--primary-soft);
            color: var(--primary);
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

        .swal2-popup {
            border-radius: 22px !important;
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
                    <i class="fas fa-box-open me-2"></i> Manajemen Produk
                </h2>

                <p class="page-desc">
                    Kelola produk konveksi, kategori, harga, foto produk, detail produk, dan status ketersediaan stok.
                </p>
            </div>
        </div>

        <div class="custom-card">
            <div class="card-content">
                <h4 class="form-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                </h4>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Kaos Custom" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php while($data=mysqli_fetch_array($querykategori)){ ?>
                                    <option value="<?php echo $data['id_kategori']?>"><?php echo $data['nama']?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="harga" class="form-label">Harga Produk (Rp)</label>
                            <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan angka saja" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label">Foto Produk</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ketersediaan_stok" class="form-label">Status Stok</label>
                            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-select">
                                <option value="tersedia">Tersedia</option>
                                <option value="habis">Habis</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="detail" class="form-label">Detail Produk</label>
                            <textarea name="detail" id="detail" rows="3" class="form-control" placeholder="Jelaskan bahan, ukuran, warna, atau detail produk konveksi..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom mt-2" name="simpan">
                        <i class="fas fa-save me-2"></i> Simpan Produk
                    </button>
                </form>

                <?php
                if(isset($_POST['simpan'])){
                    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
                    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
                    $harga    = mysqli_real_escape_string($koneksi, $_POST['harga']);
                    $detail   = mysqli_real_escape_string($koneksi, $_POST['detail']);
                    $stok     = mysqli_real_escape_string($koneksi, $_POST['ketersediaan_stok']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imagefiletype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $new_name = "";

                    if($nama=='' || $kategori=='' || $harga==''){
                        echo "<script>
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Nama, kategori, dan harga wajib diisi!',
                                icon: 'warning',
                                confirmButtonColor: '#7c3aed'
                            });
                        </script>";
                    } else {
                        if($nama_file != ''){
                            if($image_size > 5000000){
                                echo "<script>
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'File terlalu besar. Maksimal ukuran foto 5MB!',
                                        icon: 'error',
                                        confirmButtonColor: '#7c3aed'
                                    });
                                </script>";
                            } else {
                                if($imagefiletype != 'jpg' && $imagefiletype != 'png' && $imagefiletype != 'jpeg'){
                                    echo "<script>
                                        Swal.fire({
                                            title: 'Format Salah!',
                                            text: 'Foto hanya boleh berformat JPG, JPEG, atau PNG!',
                                            icon: 'error',
                                            confirmButtonColor: '#7c3aed'
                                        });
                                    </script>";
                                } else {
                                    $new_name = generateRandomString(20) . "." . $imagefiletype;
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                }
                            }
                        }

                        $queryTambah = mysqli_query($koneksi, "INSERT INTO tbl_produk (id_kategori, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$stok')");

                        if($queryTambah){
                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Produk konveksi berhasil disimpan.',
                                    icon: 'success',
                                    confirmButtonColor: '#7c3aed'
                                }).then((result) => {
                                    window.location.href = 'produk.php';
                                });
                            </script>";
                        } else {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: '" . mysqli_error($koneksi) . "',
                                    icon: 'error',
                                    confirmButtonColor: '#7c3aed'
                                });
                            </script>";
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="section-title">
                <i class="fas fa-list me-2"></i>Daftar Produk
            </h3>
            <p class="section-desc">Total produk terdaftar: <?php echo $jumlahproduk; ?> produk</p>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if($jumlahproduk == 0){ ?>
                            <tr>
                                <td colspan="6" class="text-center empty-state">
                                    <i class="fas fa-folder-open me-2"></i>Data produk masih kosong
                                </td>
                            </tr>
                        <?php } else {
                            $no = 1;
                            while($data = mysqli_fetch_array($queryproduk)){
                        ?>
                            <tr>
                                <td class="text-center fw-bold"><?php echo $no++; ?></td>

                                <td class="product-name">
                                    <?php echo $data['nama']; ?>
                                </td>

                                <td>
                                    <span class="category-badge">
                                        <i class="fas fa-tag"></i>
                                        <?php echo $data['nama_kategori']; ?>
                                    </span>
                                </td>

                                <td class="price-text">
                                    Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <span class="badge-stok <?php echo ($data['ketersediaan_stok'] == 'tersedia') ? 'stok-tersedia' : 'stok-habis'; ?>">
                                        <?php echo ucfirst($data['ketersediaan_stok']); ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn-action" title="Edit Produk">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>