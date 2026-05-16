<?php
    require "koneksi.php";

    // 1. Ambil data nama dari URL dan bersihkan untuk keamanan (SQL Injection)
    $nama = isset($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : '';

    if (empty($nama)) {
        echo "<script>alert('Nama produk tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    // 2. Query data produk utama
    $queryproduk = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE nama='$nama'");
    
    // Cek apakah query berhasil dan produknya ada
    if ($queryproduk && mysqli_num_rows($queryproduk) > 0) {
        $produk = mysqli_fetch_array($queryproduk);
        
        // 3. Query produk terkait (Hanya jika produk utama ditemukan)
        $id_kategori = $produk['id_kategori'];
        $id_sekarang = $produk['id'];
        $produkterkait = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE id_kategori='$id_kategori' AND id!='$id_sekarang' LIMIT 4");
    } else {
        // Jika nama produk tidak ada di database
        echo "<div class='container mt-5'><div class='alert alert-danger'>Produk dengan nama <b>" . htmlspecialchars($nama) . "</b> tidak ditemukan.</div></div>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Gassspol | <?php echo $produk['nama']; ?></title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .warna-bir { background-color: #007bff; } /* Sesuaikan dengan warna brand Anda */
        .produk-terkait-image:hover { transform: scale(1.05); transition: 0.3s; }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100 shadow-sm rounded-4" alt="<?php echo $produk['nama']; ?>">
                </div>
                
                <div class="col-lg-6 offset-lg-1">
                    <h1 class="fw-bold"><?php echo $produk['nama']; ?></h1>
                    
                    <div class="fs-5 mb-4 text-muted" style="text-align: justify;">
                        <?php 
                            // nl2br menjaga baris baru dari database
                            echo nl2br(htmlspecialchars($produk['detail'])); 
                        ?>
                    </div>

                    <p class="text-harga-produk fw-bold fs-3 text-primary">
                        Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                    </p>
                    
                    <p class="fs-5">
                        Status Ketersediaan : 
                        <span class="badge <?php echo ($produk['ketersediaan_stok'] == 'tersedia') ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo ucfirst($produk['ketersediaan_stok']); ?>
                        </span>
                    </p>
                    
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="keranjang.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
                                    
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white">Jumlah</span>
                                        <input type="number" name="qty" class="form-control" value="1" min="1" required>
                                    </div>
                                    
                                    <button type="submit" class="btn warna-bir text-white w-100 py-3 rounded-pill fw-bold shadow-sm">
                                        <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 warna-bir">
        <div class="container">
            <h2 class="text-center text-white mb-5 fw-bold">Produk Terkait</h2>

            <div class="row">
                <?php 
                if(mysqli_num_rows($produkterkait) > 0) {
                    while($data = mysqli_fetch_array($produkterkait)){ 
                ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                        <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top img-fluid produk-terkait-image" alt="<?php echo $data['nama']; ?>" style="aspect-ratio: 1/1; object-fit: cover;">
                        </a>
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-0"><?php echo $data['nama']; ?></h6>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<p class='text-white text-center'>Tidak ada produk terkait.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php require "footer-produk.php"; ?>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>