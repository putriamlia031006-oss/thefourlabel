<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "./koneksi.php";
$queryNavKategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori");
?>

<nav class="navbar navbar-expand-lg navbar-dark warna-lavender sticky-top shadow-sm py-2">
  <div class="container">
    
    <!-- LOGO -->
    <a class="navbar-brand fw-bold fs-4" href="index.php">
        <i class="fas fa-store me-2"></i>THE FOUR LABEL
    </a>

    <!-- TOGGLER -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      
      <!-- MENU -->
      <ul class="navbar-nav me-auto ms-lg-3">
        <li class="nav-item">
          <a class="nav-link active px-3" href="index.php">
            <i class="fas fa-home me-1"></i> Home
          </a>
        </li>       
        <li class="nav-item">
          <a class="nav-link px-3" href="produk.php">
            <i class="fas fa-box me-1"></i> Produk
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="tentang-kami.php">
            <i class="fas fa-info-circle me-1"></i> Tentang Kami
          </a>
        </li>
      </ul>

      <!-- RIGHT MENU -->
      <div class="navbar-nav ms-auto align-items-center">

        <!-- PROFIL / LOGIN -->
        <?php if (isset($_SESSION['pelanggan'])): ?>
            <div class="nav-item dropdown me-2">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fs-5 me-2"></i>
                    <span>
                        <?php echo $_SESSION['pelanggan']['nama_pelanggan'] ?? 'User'; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                        <a class="dropdown-item" href="profil.php">
                            <i class="fas fa-user me-2"></i> Profil Saya
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pesanan.php">
                            <i class="fas fa-receipt me-2"></i> Pesanan Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

        <?php else: ?>
            <div class="d-flex me-2">
                <a href="login.php" class="btn btn-sm btn-outline-light me-2">Login</a>
                <a href="register.php" class="btn btn-sm btn-light">Daftar</a>
            </div>
        <?php endif; ?>

        <!-- KERANJANG -->
        <a href="keranjang.php" class="nav-link d-flex align-items-center px-3">
            <div class="position-relative">
                <i class="fas fa-shopping-cart fs-5"></i>
                
                <?php 
                $jumlah_keranjang = 0;
                if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
                    $jumlah_keranjang = count($_SESSION['keranjang']); 
                }
                ?>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger 
                    <?php echo ($jumlah_keranjang > 0) ? '' : 'd-none'; ?>">
                    <?php echo $jumlah_keranjang; ?>
                </span>
            </div>
        </a>

        <!-- MENU KATEGORI -->
        <button class="nav-link btn border-0 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenuKategori">
            <i class="fas fa-bars fs-4 text-white"></i>
        </button>

      </div>
    </div>
  </div>
</nav>

<!-- OFFCANVAS KATEGORI -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenuKategori">
  <div class="offcanvas-header">
    <h5 class="fw-bold">KATEGORI FASHION</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body">
    <div class="row g-3">
        <?php while($kat = mysqli_fetch_array($queryNavKategori)){ 
            $nama_kat = strtolower($kat['nama']);
            $icon = "fa-tag"; 

            if (strpos($nama_kat, 'hoodie') !== false) $icon = "fa-vest";
            elseif (strpos($nama_kat, 'jam') !== false) $icon = "fa-clock";
            elseif (strpos($nama_kat, 'baju') !== false) $icon = "fa-tshirt";
            elseif (strpos($nama_kat, 'topi') !== false) $icon = "fa-hat-cowboy";
            elseif (strpos($nama_kat, 'celana') !== false) $icon = "fa-socks";
            elseif (strpos($nama_kat, 'sepatu') !== false) $icon = "fa-shoe-prints";
            elseif (strpos($nama_kat, 'tas') !== false) $icon = "fa-shopping-bag";
        ?>
            <div class="col-4">
                <a href="produk.php?kategori=<?php echo $kat['nama']; ?>" 
                   class="text-decoration-none d-block text-center p-3 rounded bg-white shadow-sm">
                    
                    <div class="mb-2">
                        <i class="fas <?php echo $icon; ?> text-primary fs-4"></i>
                    </div>

                    <span class="d-block small fw-semibold text-dark">
                        <?php echo $kat['nama']; ?>
                    </span>
                </a>
            </div>
        <?php } ?>
    </div>
  </div>
</div>