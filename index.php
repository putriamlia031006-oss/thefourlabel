<?php 
    require "koneksi.php";
    $queryproduk = mysqli_query($koneksi, "SELECT id,nama,harga,foto,detail FROM tbl_produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE FOUR LABEL</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light"> <?php require "navbar.php"; ?> 
    
    <div class="container-fluid benner d-flex align-items-center shadow-sm py-5">
        <div class="container text-center text-white">
            <h1 class="display-3 fw-bold mb-0 text-white">THE FOUR LABEL</h1>
            <p class="display-7 fw-bold mb-0 text-white">Temukan Gaya Eksklusif Anda Disini</p><br>
            <div class="col-md-6 offset-md-3">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg shadow-lg">
                        <input type="text" class="form-control border-0 ps-4" placeholder="Cari koleksi fashion..." name="keyword" style="border-radius: 50px 0 0 50px;">
                        <button type="submit" class="btn warna-lavender text-white px-4" style="border-radius: 0 50px 50px 0;">
                            <i class="fas fa-search me-2"></i>Telusuri
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori</h3>
            <div class="row mt-5 justify-content-center">
                <div class="col-md-4 mb-3 ">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=custom">Custom</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3 ">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=siap pakai">siap pakai</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid warna-lavender  py-5 shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h3 class="fw-bold mb-4">Tentang Kami</h3>
                    <div class="bg-white p-4 rounded-4 shadow-sm mx-auto" style="max-width: 700px;">
                        <p class="text-muted mb-0">
                            PROJEK ANALISIS DAN PERANCANGAN SISTEM INFROMASI <strong>SI 24 P SIM 2</strong>:
                        </p>
                        <hr class="opacity-10">
                        <div class="row mt-3">
                            <div class="col-3"><a href="https://www.instagram.com/stu_cindy?igsh=MTZlZjJ5Y2xnaGt0"><strong>Cindi Setio Rhamadani</strong></a></div>
                            <div class="col-3"><a href="https://www.instagram.com/mhsaibrhm_?igsh=MXU4dHo1ZHd3dmJ4bg=="><strong>Khanza Afifah Karina Putri</strong></a></div>
                            <div class="col-3"><a href="https://www.instagram.com/ptr.hijklnomihc?igsh=Z3VseXIydm1na3Zm&utm_source=qr"><strong>Putri Amalia Ramadani</strong></a></div>
                            <div class="col-3"><a href="https://www.instagram.com/stu_cindy?igsh=MTZlZjJ5Y2xnaGt0"><strong>Putri Sofiatun Muzofar</strong></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Koleksi Produk </h3>
            <div class="mx-auto warna-lavende" style="width: 60px; height: 4px; border-radius: 10px;"></div>
        </div>
        <div class="row g-4"> <?php while($data = mysqli_fetch_array($queryproduk)){ ?>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                    <div class="image-box" style="height: 300px; overflow: hidden;">
                        <img src="image/<?php echo $data['foto']; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $data['nama']; ?>">
                    </div>
                    <div class="card-body p-4 text-center">
                        <h5 class="card-title fw-bold text-dark"><?php echo $data['nama'];?></h5>
                        <p class="card-text text-muted small text-truncate"><?php echo $data['detail']; ?></p>
                        <p class="text-harga-produk1 fs-5 fw-bold">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                        <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>" class="btn warna-lavender text-white w-100 rounded-pill py-2 fw-bold">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="text-center mt-5">
            <a class="btn btn-outline-dark px-5 py-3 rounded-pill fw-bold" href="produk.php">
                Lihat Semua Produk <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <?php require "footer.php" ?>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>