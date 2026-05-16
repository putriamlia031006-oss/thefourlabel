<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require "koneksi.php";

    // --- 1. LOGIKA TAMBAH PRODUK (DENGAN PERBAIKAN QTY) ---
    if (isset($_GET['id'])) {
        $id_produk = $_GET['id'];
        $qty_input = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
        
        $query = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE id='$id_produk'");
        $data = mysqli_fetch_assoc($query);

        if ($data) {
            if (isset($_SESSION['keranjang'][$id_produk])) {
                $_SESSION['keranjang'][$id_produk]['jumlah'] += $qty_input;
            } else {
                $_SESSION['keranjang'][$id_produk] = [
                    'id' => $data['id'],
                    'nama' => $data['nama'],
                    'harga' => $data['harga'],
                    'foto' => $data['foto'],
                    'jumlah' => $qty_input 
                ];
            }
        }

        if (isset($_GET['ajax'])) {
            echo count($_SESSION['keranjang']);
            exit;
        }

        header("Location: keranjang.php");
        exit;
    }

    // --- 2. LOGIKA UPDATE JUMLAH ---
    if (isset($_POST['update_jumlah'])) {
        $id_update = $_POST['id_produk'];
        $jumlah_baru = $_POST['jumlah'];
        if ($jumlah_baru >= 1) {
            $_SESSION['keranjang'][$id_update]['jumlah'] = $jumlah_baru;
        }
        header("Location: keranjang.php");
        exit;
    }

    // --- 3. LOGIKA HAPUS SATUAN ---
    if (isset($_GET['hapus'])) {
        $id_hapus = $_GET['hapus'];
        unset($_SESSION['keranjang'][$id_hapus]);
        $_SESSION['status_hapus'] = "berhasil";
        header("Location: keranjang.php");
        exit;
    }

    // --- 4. LOGIKA HAPUS TERPILIH (BULK DELETE) ---
    if (isset($_POST['hapus_terpilih']) && isset($_POST['produk_pilihan'])) {
        foreach ($_POST['produk_pilihan'] as $id_pilihan) {
            unset($_SESSION['keranjang'][$id_pilihan]);
        }
        $_SESSION['status_hapus'] = "berhasil";
        header("Location: keranjang.php");
        exit;
    }

    $total_belanja = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION GASSSPOL | KERANJANG</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card-ringkasan-fix { border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #ffffff; }
        .summary-header { background: #578FCA; padding: 20px; color: white; border-radius: 15px 15px 0 0; }
        /* Mengubah warna tombol checkout menjadi Biru */
        .btn-checkout { background: #578FCA; border: none; padding: 12px; border-radius: 10px; transition: 0.3s; font-size: 0.9rem; letter-spacing: 0.5px; color: white; }
        .btn-checkout:hover:not(.disabled) { background: #4578ab; transform: translateY(-2px); color: white; }
        .total-price { font-size: 1.5rem; color: #578FCA; font-weight: 800; }
        .promo-badge { background-color: #eef5ff; color: #578FCA; padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
        .table thead th { border: none; color: #6c757d; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        .product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; transition: 0.3s; }
        .form-check-input:checked { background-color: #578FCA; border-color: #578FCA; }
        .qty-input { max-width: 80px; border-radius: 8px; border: 1px solid #dee2e6; padding: 5px; }
        /* Warna teks biru untuk subtotal */
        .text-subtotal { color: #578FCA; font-weight: bold; }
        /* Link warna biru */
        .text-blue-custom { color: #578FCA !important; }
    </style>
</head>
<body>
    
    <?php require "navbar.php"; ?>

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted small">Home</a></li>
                <li class="breadcrumb-item active small text-blue-custom fw-bold" aria-current="page">Keranjang</li>
            </ol>
        </nav>

        <div class="row align-items-end mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold mb-0">Tas Belanja Anda</h3>
                <p class="text-muted small">Pastikan item yang Anda pilih sudah sesuai</p>
            </div>
            <div class="col-md-6 text-md-end">
                <?php if (!empty($_SESSION['keranjang'])): ?>
                    <button type="button" id="btn-hapus-massal" class="btn btn-outline-danger btn-sm rounded-pill px-4 d-none shadow-sm">
                        <i class="fas fa-trash-alt me-2"></i>Hapus Terpilih (<span id="count-terpilih">0</span>)
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <form id="form-bulk-delete" action="" method="POST">
                    <input type="hidden" name="hapus_terpilih" value="1">
                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; overflow: hidden;">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-white">
                                    <tr>
                                        <th class="ps-4 py-4" style="width: 50px;">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </th>
                                        <th class="py-4">Produk</th>
                                        <th class="py-4">Harga</th>
                                        <th class="py-4 text-center">Qty</th>
                                        <th class="py-4">Subtotal</th>
                                        <th class="pe-4 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php if (empty($_SESSION['keranjang'])): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fas fa-shopping-bag fa-4x mb-3 text-light"></i>
                                                    <h5 class="text-muted">Keranjang Anda kosong</h5>
                                                    <a href="produk.php" class="btn btn-checkout rounded-pill px-4 mt-2">Mulai Belanja</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($_SESSION['keranjang'] as $id => $item): 
                                            $subtotal = $item['harga'] * $item['jumlah']; 
                                            $total_belanja += $subtotal;
                                        ?>
                                            <tr class="border-top">
                                                <td class="ps-4">
                                                    <input class="form-check-input item-checkbox" type="checkbox" name="produk_pilihan[]" value="<?php echo $id; ?>">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center py-2">
                                                        <img src="image/<?php echo $item['foto']; ?>" class="product-img shadow-sm border">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0 fw-bold text-dark"><?php echo $item['nama']; ?></h6>
                                                            <small class="text-muted">ID: #<?php echo $id; ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-dark small fw-semibold">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span></td>
                                                <td class="text-center">
                                                    <input type="number" form="form-update-<?php echo $id; ?>" name="jumlah" class="form-control form-control-sm text-center mx-auto qty-input fw-bold" value="<?php echo $item['jumlah']; ?>" min="1" onchange="document.getElementById('form-update-<?php echo $id; ?>').submit()">
                                                </td>
                                                <td><span class="text-subtotal">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span></td>
                                                <td class="pe-4 text-end">
                                                    <button type="button" class="btn btn-light btn-sm rounded-circle text-danger shadow-sm border" onclick="konfirmasiHapus('<?php echo $id; ?>')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

                <?php if (!empty($_SESSION['keranjang'])): ?>
                    <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                        <form id="form-update-<?php echo $id; ?>" action="" method="POST" style="display:none;">
                            <input type="hidden" name="id_produk" value="<?php echo $id; ?>">
                            <input type="hidden" name="update_jumlah" value="1">
                        </form>
                    <?php endforeach; ?>
                <?php endif; ?>

                <a href="produk.php" class="btn btn-link text-decoration-none text-muted p-0 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                </a>
            </div>

            <div class="col-lg-4">
                <div class="card card-ringkasan-fix shadow-sm">
                    <div class="summary-header">
                        <h6 class="fw-bold mb-0"><i class="fas fa-receipt me-2"></i>Ringkasan Pesanan</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Harga (<?php echo empty($_SESSION['keranjang']) ? 0 : count($_SESSION['keranjang']); ?> item)</span>
                            <span class="fw-bold">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="promo-badge">FREE SHIPPING</span>
                        </div>
                        <hr class="my-4" style="border-style: dashed; color: #dee2e6;">
                        <div class="mb-4">
                            <span class="d-block text-muted small mb-1 fw-bold text-uppercase">Total Pembayaran</span>
                            <span class="total-price">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                        </div>
                        <a href="checkout.php" class="btn btn-checkout w-100 fw-bold shadow-sm mb-3 <?php echo empty($_SESSION['keranjang']) ? 'disabled' : ''; ?>">
                            PROSES CHECKOUT <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <div class="text-center">
                            <small class="text-muted"><i class="fas fa-shield-alt me-1 text-blue-custom"></i> Pembayaran Aman & Terenkripsi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer-keranjang.php"; ?>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>

    <script>
        const selectAll = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const btnHapusMassal = document.getElementById('btn-hapus-massal');
        const countTerpilih = document.getElementById('count-terpilih');

        function updateHapusButton() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (checkedCount > 0) {
                btnHapusMassal.classList.remove('d-none');
                countTerpilih.innerText = checkedCount;
            } else {
                btnHapusMassal.classList.add('d-none');
            }
        }

        if(selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => cb.checked = this.checked);
                updateHapusButton();
            });
        }

        itemCheckboxes.forEach(cb => { cb.addEventListener('change', updateHapusButton); });

        btnHapusMassal.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus produk terpilih?',
                text: "Item yang Anda pilih akan dikeluarkan dari keranjang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => { if (result.isConfirmed) { document.getElementById('form-bulk-delete').submit(); } })
        });

        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Keluarkan produk?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#578FCA',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => { if (result.isConfirmed) { window.location.href = "keranjang.php?hapus=" + id; } })
        }

        <?php if(isset($_SESSION['status_hapus'])): ?>
            Swal.fire({ 
                title: 'Berhasil!', 
                text: 'Keranjang Anda telah diperbarui.', 
                icon: 'success', 
                confirmButtonColor: '#578FCA',
                timer: 2000,
                borderRadius: '15px'
            });
            <?php unset($_SESSION['status_hapus']); ?>
        <?php endif; ?>
    </script>
</body>
</html>