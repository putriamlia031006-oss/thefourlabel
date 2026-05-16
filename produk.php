<?php
    require "koneksi.php";

    $querykategori = mysqli_query($koneksi,"SELECT * FROM tbl_kategori");
    
    // Logika Filter Produk (Keyword/Kategori)
    if(isset($_GET['keyword'])){
        $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
        $queryproduk = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE nama LIKE '%$keyword%'");
    } else if(isset($_GET['kategori'])){
        $kategori_nama = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        
        // PERBAIKAN: Menggunakan id_kategori sesuai struktur database
        $querygetkategoriid = mysqli_query($koneksi, "SELECT id_kategori FROM tbl_kategori WHERE nama='$kategori_nama'");
        $kategoriid = mysqli_fetch_array($querygetkategoriid);
        
        $queryproduk = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE id_kategori='$kategoriid[id_kategori]'");
    } else{
        $queryproduk = mysqli_query($koneksi, "SELECT * FROM tbl_produk");
    }

    $countdata = mysqli_num_rows($queryproduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEH FOUR LABEL | Produk</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Animasi Keranjang */
        .cart-animate {
            animation: cart-shake 0.5s ease-in-out;
        }

        @keyframes cart-shake {
            0% { transform: scale(1); }
            25% { transform: scale(1.2) rotate(5deg); }
            50% { transform: scale(0.8) rotate(-5deg); }
            100% { transform: scale(1); }
        }

        .cart-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            /* PERUBAHAN: Warna Background menjadi Hijau */
            background: #198754; 
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 10000;
            display: none;
            font-weight: 500;
        }

        .show-toast {
            display: block !important;
            animation: slideUp 0.4s ease-out forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hide-toast {
            animation: slideDown 0.4s ease-in forwards;
        }

        @keyframes slideDown {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(50px); }
        }

        /* Styling Kategori Horizontal */
        .category-scroll {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 15px;
            gap: 10px;
            scrollbar-width: none;
        }
        
        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            display: inline-block;
            padding: 8px 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 50px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .category-pill:hover, .category-pill.active {
            background-color: #C68EFD;
            color: white;
            border-color: #C68EFD;
            box-shadow: 0 4px 10px rgba(54, 116, 181, 0.2);
        }

        .card-img-top {
            transition: transform 0.5s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        .btn-detail-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
        }

        /* PERBAIKAN: Menyamakan tinggi elemen agar harga sejajar */
        .product-title {
            height: 2.6rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-description {
            height: 3rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="container-fluid benner2 d-flex align-items-center">
        <div class="container text-white text-center hero-content">
            <h1 class="display-1 fw-bold mb-3 text-white">Produk</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold">Pilih Kategori</h3>
            </div>
            <div class="col-12">
                <div class="category-scroll justify-content-center">
                    <a href="produk.php" class="category-pill <?php echo !isset($_GET['kategori']) ? 'active' : ''; ?>">
                        Semua Produk
                    </a>
                    <?php while($kategori = mysqli_fetch_array($querykategori)){ ?>
                    <a href="produk.php?kategori=<?php echo $kategori['nama']; ?>" 
                       class="category-pill <?php echo (isset($_GET['kategori']) && $_GET['kategori'] == $kategori['nama']) ? 'active' : ''; ?>"> 
                        <?php echo $kategori['nama']; ?>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <hr class="mb-5 opacity-10">

        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-5 fw-bold">Koleksi Kami</h3>
                <div class="row g-4"> 
                    <?php if($countdata < 1){ ?>
                        <div class="col-12 text-center my-5">
                            <h4 class="text-muted">Produk yang Anda cari tidak tersedia</h4>
                        </div>
                    <?php } ?>

                    <?php while($produk = mysqli_fetch_array($queryproduk)){ ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"> 
                        <div class="card h-100 shadow-sm border-0">
                            <div class="image-box" style="overflow: hidden;">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" style="aspect-ratio: 1/1; object-fit: cover;">
                            </div>
                            <div class="card-body d-flex flex-column text-center">
                                <h5 class="card-title fw-bold product-title" style="font-size: 1.1rem;"><?php echo $produk['nama']; ?></h5>
                                
                                <p class="card-text text-muted small mb-3 product-description">
                                    <?php 
                                        $clean_detail = strip_tags($produk['detail']); 
                                        echo $clean_detail; 
                                    ?>
                                </p>
                                
                                <p class="card-text fw-bold text-secondary fs-5 mb-3 mt-auto">
                                    Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                                </p>
                                
                                <div class="d-flex justify-content-between gap-2">
                                    <a href="produk-detail.php?nama=<?php echo urlencode($produk['nama']); ?>" 
                                       class="btn btn-outline-secondary w-100 fw-bold btn-sm btn-detail-custom">
                                       Detail
                                    </a>
                                    
                                    <button type="button" class="btn btn-secondary add-to-cart-btn btn-detail-custom" data-id="<?php echo $produk['id']; ?>">
                                         <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div id="cart-notification" class="cart-toast">
        <i class="fas fa-check-circle me-2"></i> Berhasil masuk keranjang!
    </div>

    <?php require "footer-produk.php"; ?>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>

<script>
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const produkId = this.getAttribute('data-id');
        const btn = this;

        btn.classList.add('cart-animate');
        setTimeout(() => btn.classList.remove('cart-animate'), 500);

        fetch(`keranjang.php?id=${produkId}&ajax=1`)
            .then(response => response.text())
            .then(totalBaru => {
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = totalBaru.trim();
                    badge.classList.remove('d-none');
                    
                    badge.animate([
                        { transform: 'translate(-50%, -50%) scale(1)' },
                        { transform: 'translate(-50%, -50%) scale(1.5)' },
                        { transform: 'translate(-50%, -50%) scale(1)' }
                    ], { duration: 300 });
                }

                const toast = document.getElementById('cart-notification');
                toast.classList.remove('hide-toast');
                toast.classList.add('show-toast');
                
                setTimeout(() => {
                    toast.classList.add('hide-toast');
                    setTimeout(() => toast.classList.remove('show-toast'), 400);
                }, 2500);
            })
            .catch(err => console.error("Error:", err));
    });
});
</script>

</body>
</html>