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
    <title>Manajemen Produk | Fashion Gassspol</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-color: #3674B5;
            --dark-blue: #234e7a;
            --bg-body: #f4f7fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: #333;
        }

        .page-title { font-weight: 700; color: #2C3E50; margin-bottom: 30px; }

        .custom-card {
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .form-label { font-weight: 600; color: #555; }
        
        .form-control, .form-select {
            border-radius: 12px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }

        .table-container {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .table thead { background-color: var(--primary-color); color: white; }
        .table thead th { padding: 15px; border: none; }

        .badge-stok {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background-color: #f0f4f8;
            color: var(--primary-color);
            text-decoration: none;
        }
        .btn-action:hover { background-color: var(--primary-color); color: white; }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5 pb-5">
        <h2 class="page-title">
            <i class="fas fa-box-open text-primary me-2"></i> Manajemen Produk
        </h2>

        <div class="custom-card mb-5">
            <h4 class="mb-4 fw-bold text-primary">Tambah Produk Baru</h4>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Hoodie Oversize" required>
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
                        <label for="harga" class="form-label">Harga (Rp)</label>
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
                        <textarea name="detail" id="detail" rows="3" class="form-control" placeholder="Jelaskan deskripsi produk..."></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary px-4 mt-2 shadow-sm" style="border-radius: 10px;" name="simpan">
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
                    echo "<script>Swal.fire('Opps!', 'Nama, Kategori, dan Harga wajib diisi!', 'warning');</script>";
                } else {
                    if($nama_file != ''){
                        if($image_size > 5000000){
                            echo "<script>Swal.fire('Gagal!', 'File terlalu besar (Maks 5MB)!', 'error');</script>";
                        } else {
                            if($imagefiletype != 'jpg' && $imagefiletype != 'png' && $imagefiletype != 'jpeg'){
                                echo "<script>Swal.fire('Format Salah!', 'Hanya mendukung JPG/PNG!', 'error');</script>";
                            } else {
                                $new_name = generateRandomString(20) . "." . $imagefiletype;
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }

                    $queryTambah = mysqli_query($koneksi, "INSERT INTO tbl_produk (id_kategori, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$stok')");

                    if($queryTambah){
                        echo "
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        <script>
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Produk Baru Telah Tersimpan',
                                icon: 'success',
                                confirmButtonColor: '#3674B5'
                            }).then((result) => {
                                window.location.href = 'produk.php';
                            });
                        </script>";
                    } else {
                        echo "<script>Swal.fire('Error!', '" . mysqli_error($koneksi) . "', 'error');</script>";
                    }
                }
            }
            ?>
        </div>

        <h3 class="fw-bold mb-4">Daftar Produk</h3>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($jumlahproduk == 0){ ?>
                            <tr><td colspan="6" class="text-center py-5">Data Kosong</td></tr>
                        <?php } else {
                            $no = 1;
                            while($data = mysqli_fetch_array($queryproduk)){
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="fw-bold"><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['nama_kategori']; ?></td>
                                <td class="text-success fw-bold">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge-stok <?php echo ($data['ketersediaan_stok'] == 'tersedia') ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>">
                                        <?php echo ucfirst($data['ketersediaan_stok']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn-action shadow-sm">
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