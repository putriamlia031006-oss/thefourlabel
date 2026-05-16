<?php   
    require "session.php";
    require "../koneksi.php";

    $id = mysqli_real_escape_string($koneksi, $_GET['p']);

    $query = mysqli_query($koneksi,"SELECT a.*, b.nama AS nama_kategori FROM tbl_produk a JOIN tbl_kategori b ON a.id_kategori=b.id_kategori WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);
    $querykategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE id_kategori!='$data[id_kategori]'");  

    if(mysqli_num_rows($query) == 0){
        header('location: produk.php');
    }

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Fashion Gassspol</title>
    
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
        .no-decoration { text-decoration: none; }
        .custom-card {
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
        }
        .form-label { font-weight: 600; color: #555; margin-top: 15px; }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
        }
        .img-preview {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 15px;
            border: 5px solid #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .btn-custom { border-radius: 12px; padding: 12px 25px; font-weight: 600; }
    </style>
</head>

<body>
    <?php require "navbar.php" ?>
    
    <div class="container mt-5 mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="produk.php" class="no-decoration text-muted">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="custom-card">
                    <h2 class="fw-bold mb-4 text-center" style="color: var(--dark-blue);">Manajemen Detail Produk</h2>

                    <form action="" method="post" enctype="multipart/form-data" id="formProduk">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="nama" class="form-label">Nama Produk</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama'];?>" autocomplete="off" required>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-select" required>
                                            <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori'];?></option>
                                            <?php while($datakategori=mysqli_fetch_array($querykategori)){ ?>
                                                <option value="<?php echo $datakategori['id_kategori']?>"><?php echo $datakategori['nama']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="harga" class="form-label">Harga (Rp)</label>
                                        <input type="number" name="harga" id="harga" value="<?php echo $data['harga']; ?>" class="form-control" required >
                                    </div>
                                </div>

                                <label for="detail" class="form-label">Deskripsi Produk</label>
                                <textarea name="detail" id="detail" rows="4" class="form-control"><?php echo $data['detail'];?></textarea>

                                <label for="ketersediaan_stok" class="form-label">Status Stok</label>
                                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-select mb-4">
                                    <option value="tersedia" <?php echo ($data['ketersediaan_stok']=='tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                    <option value="habis" <?php echo ($data['ketersediaan_stok']=='habis') ? 'selected' : ''; ?>>Habis</option>
                                </select>
                            </div>

                            <div class="col-md-5 text-center">
                                <label class="form-label d-block text-start">Pratinjau Foto</label>
                                <img src="../image/<?php echo $data['foto']; ?>" id="img-display" class="img-preview mb-3" alt="Foto Produk">
                                <div class="text-start">
                                    <label for="foto" class="form-label">Ganti Foto Baru</label>
                                    <input type="file" name="foto" id="foto-input" class="form-control">
                                    <small class="text-muted">Max: 10MB (JPG/PNG/GIF)</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <button type="submit" class="btn btn-primary btn-custom px-5 shadow" name="simpan">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            
                            <button type="button" class="btn btn-danger btn-custom px-5 shadow" onclick="konfirmasiHapus()">
                                <i class="fas fa-trash-alt me-2"></i> Hapus Produk
                            </button>

                            <input type="hidden" name="hapus" id="inputHapus" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Preview Gambar
        const fotoInput = document.getElementById('foto-input');
        const imgDisplay = document.getElementById('img-display');
        fotoInput.onchange = evt => {
            const [file] = fotoInput.files;
            if (file) { imgDisplay.src = URL.createObjectURL(file); }
        }

        // Fungsi Konfirmasi Hapus
        function konfirmasiHapus() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data produk akan dihapus permanen dari database!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set value input hidden dan submit form secara manual
                    document.getElementById('inputHapus').value = "1";
                    document.getElementById('formProduk').submit();
                }
            })
        }
    </script>

    <?php
    // LOGIKA UPDATE
    if(isset($_POST['simpan'])){
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
        $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
        $detail = mysqli_real_escape_string($koneksi, $_POST['detail']);
        $stok = mysqli_real_escape_string($koneksi, $_POST['ketersediaan_stok']);

        $target_dir = "../image/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $nama_file;
        $imagefiletype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];

        $queryUpdate = mysqli_query($koneksi, "UPDATE tbl_produk SET id_kategori='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$stok' WHERE id='$id'");

        if($nama_file != ''){
            if($image_size > 10000000){
                echo "<script>Swal.fire('Gagal!', 'Ukuran foto terlalu besar (Max 10MB)', 'error');</script>";
            } else if($imagefiletype != 'jpg' && $imagefiletype != 'png' && $imagefiletype != 'jpeg' && $imagefiletype != 'gif'){
                echo "<script>Swal.fire('Gagal!', 'Format file tidak didukung!', 'error');</script>";
            } else {
                $new_name = generateRandomString(20) . "." . $imagefiletype;
                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                mysqli_query($koneksi, "UPDATE tbl_produk SET foto='$new_name' WHERE id='$id'");
            }
        }

        if($queryUpdate){
            echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data produk telah diperbarui',
                    icon: 'success',
                    confirmButtonColor: '#3674B5'
                }).then(() => {
                    window.location.href = 'produk.php';
                });
            </script>";
        }
    }

    // LOGIKA HAPUS (Dicu melalui JavaScript)
    if(isset($_POST['hapus']) && $_POST['hapus'] == "1"){
        $queryhapus = mysqli_query($koneksi, "DELETE FROM tbl_produk WHERE id='$id'");
        if($queryhapus){
            echo "
            <script>
                Swal.fire({
                    title: 'Terhapus!',
                    text: 'Produk berhasil dihilangkan',
                    icon: 'success',
                    confirmButtonColor: '#3674B5'
                }).then(() => {
                    window.location.href = 'produk.php';
                });
            </script>";
        }
    }
    ?>
</body>
</html>