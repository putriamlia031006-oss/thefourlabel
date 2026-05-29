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
    <title>THE FOUR LABEL | KERANJANG</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-light: #a78bfa;
            --primary-soft: #ede9fe;
            --primary-bg: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.16), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            color: var(--text-dark);
        }

        .card-ringkasan-fix {
            border-radius: 18px;
            border: 1px solid rgba(124, 58, 237, 0.10);
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.10);
            background: #ffffff;
            overflow: hidden;
        }

        .summary-header {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            padding: 20px;
            color: white;
            border-radius: 18px 18px 0 0;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            border: none;
            padding: 12px;
            border-radius: 12px;
            transition: 0.3s;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            color: white;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-checkout:hover:not(.disabled) {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 10px 22px rgba(76, 29, 149, 0.25);
        }

        .total-price {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 800;
        }

        .promo-badge {
            background-color: var(--primary-soft);
            color: var(--primary-dark);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .table thead th {
            border: none;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table tbody tr:hover {
            background-color: #faf5ff;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            transition: 0.3s;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.18);
            border-color: var(--primary);
        }

        .qty-input {
            max-width: 80px;
            border-radius: 8px;
            border: 1px solid rgba(124, 58, 237, 0.18);
            padding: 5px;
        }

        .qty-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.14);
        }

        .text-subtotal {
            color: var(--primary);
            font-weight: 800;
        }

        .text-lavender-custom {
            color: var(--primary) !important;
        }

        .cart-card {
            border-radius: 18px !important;
            overflow: hidden;
            border: 1px solid rgba(124, 58, 237, 0.09) !important;
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08) !important;
        }

        .btn-remove {
            background: #fff;
            color: #dc3545;
            border: 1px solid #fee2e2;
        }

        .btn-remove:hover {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    
    <?php require "navbar.php"; ?>

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php" class="text-decoration-none text-muted small">Home</a>
                </li>
                <li class="breadcrumb-item active small text-lavender-custom fw-bold" aria-current="page">
                    Keranjang
                </li>
            </ol>
        </nav>

        <div class="row align-items-end mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold mb-0" style="color: var(--primary-dark);">Tas Belanja Anda</h3>
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

                    <div class="card border-0 mb-4 cart-card">
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
                                                    <i class="fas fa-shopping-bag fa-4x mb-3" style="color: #ddd6fe;"></i>
                                                    <h5 class="text-muted">Keranjang Anda kosong</h5>
                                                    <a href="produk.php" class="btn btn-checkout rounded-pill px-4 mt-2">
                                                        Mulai Belanja
                                                    </a>
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
                                                            <h6 class="mb-0 fw-bold" style="color: var(--primary-dark);">
                                                                <?php echo $item['nama']; ?>
                                                            </h6>
                                                            <small class="text-muted">ID: #<?php echo $id; ?></small>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="text-dark small fw-semibold">
                                                        Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <input 
                                                        type="number" 
                                                        form="form-update-<?php echo $id; ?>" 
                                                        name="jumlah" 
                                                        class="form-control form-control-sm text-center mx-auto qty-input fw-bold" 
                                                        value="<?php echo $item['jumlah']; ?>" 
                                                        min="1" 
                                                        onchange="document.getElementById('form-update-<?php echo $id; ?>').submit()"
                                                    >
                                                </td>

                                                <td>
                                                    <span class="text-subtotal">
                                                        Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                                                    </span>
                                                </td>

                                                <td class="pe-4 text-end">
                                                    <button type="button" class="btn btn-sm rounded-circle shadow-sm btn-remove" onclick="konfirmasiHapus('<?php echo $id; ?>')">
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
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                        </h6>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Total Harga (<?php echo empty($_SESSION['keranjang']) ? 0 : count($_SESSION['keranjang']); ?> item)
                            </span>
                            <span class="fw-bold">
                                Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="promo-badge">FREE SHIPPING</span>
                        </div>

                        <hr class="my-4" style="border-style: dashed; color: #ddd6fe;">

                        <div class="mb-4">
                            <span class="d-block text-muted small mb-1 fw-bold text-uppercase">
                                Total Pembayaran
                            </span>
                            <span class="total-price">
                                Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?>
                            </span>
                        </div>

                        <a href="checkout.php" class="btn btn-checkout w-100 fw-bold shadow-sm mb-3 <?php echo empty($_SESSION['keranjang']) ? 'disabled' : ''; ?>">
                            PROSES CHECKOUT <i class="fas fa-arrow-right ms-2"></i>
                        </a>

                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1 text-lavender-custom"></i> Pembayaran Aman & Terenkripsi
                            </small>
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

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => cb.checked = this.checked);
                updateHapusButton();
            });
        }

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateHapusButton);
        });

        if (btnHapusMassal) {
            btnHapusMassal.addEventListener('click', function() {
                Swal.fire({
                    title: 'Hapus produk terpilih?',
                    text: "Item yang Anda pilih akan dikeluarkan dari keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#7c3aed',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-bulk-delete').submit();
                    }
                });
            });
        }

        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Keluarkan produk?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7c3aed',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "keranjang.php?hapus=" + id;
                }
            });
        }

        <?php if(isset($_SESSION['status_hapus'])): ?>
            Swal.fire({ 
                title: 'Berhasil!', 
                text: 'Keranjang Anda telah diperbarui.', 
                icon: 'success', 
                confirmButtonColor: '#7c3aed',
                timer: 2000
            });
            <?php unset($_SESSION['status_hapus']); ?>
        <?php endif; ?>
    </script>
</body>
</html>