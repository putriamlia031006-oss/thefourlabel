<?php
    session_start();
    require "koneksi.php";

    if (!isset($_SESSION["pelanggan"])) {
        echo "<script>alert('Silahkan login atau daftar akun terlebih dahulu untuk checkout');</script>";
        echo "<script>location='login.php';</script>";
        exit;
    }

    if (empty($_SESSION['keranjang'])) {
        echo "<script>alert('Keranjang belanja Anda kosong!');</script>";
        echo "<script>location='produk.php';</script>";
        exit;
    }

    $total_belanja = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total_belanja += ($item['harga'] * $item['jumlah']);
    }

    $biaya_layanan = 1000;
    $total_final = $total_belanja + $biaya_layanan;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan | The Four Label</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-soft: #ede9fe;
            --primary-light: #c4b5fd;
            --bg-body: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
        }

        * {
            box-sizing: border-box;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            color: var(--text-dark);
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 32%),
                radial-gradient(circle at bottom right, rgba(196, 181, 253, 0.24), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            min-height: 100vh;
        }

        .checkout-title {
            color: var(--primary-dark);
            font-weight: 800;
        }

        .checkout-subtitle {
            color: var(--text-muted);
            font-size: 15px;
        }

        .checkout-card { 
            border: 1px solid rgba(124, 58, 237, 0.10);
            border-radius: 22px; 
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 12px 28px rgba(76, 29, 149, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .checkout-card:hover {
            box-shadow: 0 16px 34px rgba(76, 29, 149, 0.12);
        }
        
        .form-control {
            border: 1.5px solid rgba(124, 58, 237, 0.14);
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 0.95rem;
            background-color: #fbfaff;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.14);
            background-color: white;
        }

        .step-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .step-number { 
            width: 36px;
            height: 36px; 
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            color: white;
            border-radius: 12px;
            display: inline-flex; 
            align-items: center;
            justify-content: center; 
            margin-right: 12px;
            font-weight: 800;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .step-header h5 {
            color: var(--primary-dark);
            font-weight: 800;
        }

        .selection-card {
            cursor: pointer;
            border: 2px solid #eee7ff;
            border-radius: 16px;
            padding: 18px;
            transition: all 0.2s ease;
            height: 100%;
            display: block;
            position: relative;
            background: white;
        }

        .selection-card:hover {
            border-color: var(--primary);
            background-color: #faf5ff;
            transform: translateY(-2px);
        }

        .form-check-input:checked + .selection-card {
            border-color: var(--primary);
            background-color: rgba(124, 58, 237, 0.07);
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.12);
        }

        .selection-title {
            color: var(--primary);
            font-weight: 800;
        }

        .pay-transfer {
            border-left: 5px solid var(--primary);
        }

        .pay-ewallet {
            border-left: 5px solid #a855f7;
        }

        .pay-cod {
            border-left: 5px solid #4c1d95;
        }

        .prod-img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 14px;
            background: #f1f5f9;
            border: 1px solid #e5e7eb;
            cursor: pointer;
        }

        .product-name {
            color: var(--primary-dark);
            font-weight: 800;
        }

        .price-purple {
            color: var(--primary);
            font-weight: 800;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            border: none;
            padding: 17px;
            border-radius: 15px;
            font-weight: 800;
            font-size: 1rem;
            transition: 0.3s;
            color: white;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 22px rgba(124, 58, 237, 0.22);
        }

        .btn-checkout:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(76, 29, 149, 0.28);
            color: white;
        }

        .summary-box {
            background: #ffffff;
            border-top: 5px solid var(--primary);
            border-radius: 22px; 
        }

        .text-purple-primary {
            color: var(--primary) !important;
        }

        .badge-info-flow {
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .error-msg {
            display: none;
            color: #dc3545;
            font-size: 0.85rem;
            font-weight: 700;
            margin-top: 10px;
            background: #fff8f8;
            padding: 8px 13px;
            border-radius: 10px;
            border: 1px solid #f8d7da;
        }

        .back-link {
            color: var(--text-muted);
            font-weight: 800;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        #box-ekspedisi {
            display: none;
        }

        @media (max-width: 768px) {
            .border-end {
                border-right: none !important;
            }
        }
    </style>
</head>

<body>
    <?php require "navbar-checkout.php"; ?>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <span class="badge-info-flow mb-3">
                    <i class="fas fa-diagram-project"></i>
                    Pemesanan Produk & Pembayaran
                </span>
                <h2 class="checkout-title">Konfirmasi Pesanan</h2>
                <p class="checkout-subtitle">
                    Lengkapi data pesanan, pilih ambil di toko atau dikirim, lalu konfirmasi pembayaran.
                </p>
            </div>
        </div>
        
        <form action="proses-checkout.php" method="POST" id="formCheckout">
            <div class="row justify-content-center">
                <div class="col-lg-10"> 

                    <div class="card checkout-card mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">1</span>
                                <h5 class="mb-0">Jenis Pesanan</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="radio" class="form-check-input d-none" name="jenis_transaksi" id="siap_pakai" value="ready stock" checked>
                                    <label for="siap_pakai" class="selection-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="selection-title d-block">Siap Pakai</span>
                                                <small class="text-muted">Produk ready stock dari katalog.</small>
                                            </div>
                                            <i class="fas fa-shirt text-purple-primary"></i>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input type="radio" class="form-check-input d-none" name="jenis_transaksi" id="custom" value="custom">
                                    <label for="custom" class="selection-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="selection-title d-block">Custom</span>
                                                <small class="text-muted">Pesanan berdasarkan kebutuhan pelanggan.</small>
                                            </div>
                                            <i class="fas fa-pen-ruler text-purple-primary"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card checkout-card mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">2</span>
                                <h5 class="mb-0">Informasi Customer</h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Penerima</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap penerima" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Nomor WhatsApp</label>
                                    <input type="number" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="nama@contoh.com" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control" rows="1" placeholder="Isi alamat jika pesanan dikirim" style="min-height: 50px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card checkout-card mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">3</span>
                                <h5 class="mb-0">Metode Pengambilan Pesanan</h5>
                            </div>

                            <p class="small text-muted mb-3">
                                * Pilih apakah pesanan akan diambil langsung di toko atau dikirim ke alamat customer.
                            </p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="radio" class="form-check-input d-none" name="metode_pengambilan" id="ambil_toko" value="Ambil di Toko">
                                    <label for="ambil_toko" class="selection-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="selection-title d-block">Ambil di Toko</span>
                                                <small class="text-muted">Customer mengambil pesanan langsung di toko.</small>
                                            </div>
                                            <i class="fas fa-store text-purple-primary"></i>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input type="radio" class="form-check-input d-none" name="metode_pengambilan" id="dikirim" value="Dikirim ke Alamat">
                                    <label for="dikirim" class="selection-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="selection-title d-block">Dikirim ke Alamat</span>
                                                <small class="text-muted">Pesanan dikirim menggunakan jasa pengiriman.</small>
                                            </div>
                                            <i class="fas fa-truck-fast text-purple-primary"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div id="error-metode-pengambilan" class="error-msg">
                                <i class="fas fa-exclamation-circle me-1"></i> Silahkan pilih metode pengambilan pesanan.
                            </div>

                            <div id="box-ekspedisi" class="mt-4">
                                <p class="small text-muted mb-3">* Pilih jasa pengiriman untuk pesanan yang dikirim.</p>

                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-4">
                                        <input type="radio" class="form-check-input d-none" name="ekspedisi" id="jne" value="JNE">
                                        <label for="jne" class="selection-card">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="selection-title d-block">JNE Reguler</span>
                                                    <small class="text-muted">2-3 Hari</small>
                                                </div>
                                                <i class="fas fa-truck text-muted"></i>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <input type="radio" class="form-check-input d-none" name="ekspedisi" id="jnt" value="J&T">
                                        <label for="jnt" class="selection-card">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="selection-title d-block">J&T Express</span>
                                                    <small class="text-muted">1-2 Hari</small>
                                                </div>
                                                <i class="fas fa-bolt text-muted"></i>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <input type="radio" class="form-check-input d-none" name="ekspedisi" id="sicepat" value="SiCepat">
                                        <label for="sicepat" class="selection-card">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="selection-title d-block">SiCepat Reg</span>
                                                    <small class="text-muted">1-2 Hari</small>
                                                </div>
                                                <i class="fas fa-shipping-fast text-muted"></i>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <input type="radio" class="form-check-input d-none" name="ekspedisi" id="gosend" value="GoSend/Grab">
                                        <label for="gosend" class="selection-card">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="selection-title d-block">Instant/Sameday</span>
                                                    <small class="text-muted">6-8 Jam</small>
                                                </div>
                                                <i class="fas fa-motorcycle text-muted"></i>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div id="error-ekspedisi" class="error-msg">
                                    <i class="fas fa-exclamation-circle me-1"></i> Silahkan pilih jasa pengiriman terlebih dahulu.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card checkout-card mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">4</span>
                                <h5 class="mb-0">Metode Pembayaran</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="transfer" value="Transfer Bank">
                                    <label for="transfer" class="selection-card pay-transfer">
                                        <span class="fw-bold d-block text-purple-primary">Transfer Bank</span>
                                        <small class="text-muted">Upload bukti pembayaran setelah checkout.</small>
                                    </label>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="ewallet" value="E-Wallet">
                                    <label for="ewallet" class="selection-card pay-ewallet">
                                        <span class="fw-bold d-block text-purple-primary">E-Wallet</span>
                                        <small class="text-muted">Pembayaran digital.</small>
                                    </label>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="cod" value="COD">
                                    <label for="cod" class="selection-card pay-cod">
                                        <span class="fw-bold d-block">COD</span>
                                        <small class="text-muted">Bayar saat barang diterima.</small>
                                    </label>
                                </div>
                            </div>

                            <div id="error-pembayaran" class="error-msg">
                                <i class="fas fa-exclamation-circle me-1"></i> Silahkan pilih metode pembayaran terlebih dahulu.
                            </div>
                        </div>
                    </div>

                    <div class="card checkout-card mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">5</span>
                                <h5 class="mb-0">Review Produk</h5>
                            </div>

                            <?php foreach ($_SESSION['keranjang'] as $key => $item): ?>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="image/<?php echo $item['foto']; ?>" class="prod-img" data-bs-toggle="modal" data-bs-target="#modalGambar<?php echo $key; ?>">
                                
                                <div class="ms-4 flex-grow-1">
                                    <h6 class="mb-1 product-name"><?php echo $item['nama']; ?></h6>
                                    <span class="text-muted small">
                                        <?php echo $item['jumlah']; ?> unit x Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                    </span>
                                </div>

                                <div class="text-end price-purple">
                                    Rp <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?>
                                </div>
                            </div>

                            <div class="modal fade" id="modalGambar<?php echo $key; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 bg-transparent">
                                        <div class="modal-body p-0 text-center position-relative">
                                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <img src="image/<?php echo $item['foto']; ?>" class="img-fluid rounded shadow-lg">
                                            <div class="bg-white p-2 rounded-bottom">
                                                <span class="fw-bold"><?php echo $item['nama']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card checkout-card shadow-lg summary-box mb-5">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">6</span>
                                <h5 class="fw-bold mb-0">Konfirmasi Pembayaran</h5>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-7 border-end">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal Produk</span>
                                        <span class="fw-semibold">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Biaya Pengiriman</span>
                                        <span class="text-purple-primary fw-bold">Menyesuaikan Metode</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Biaya Layanan</span>
                                        <span class="fw-semibold">Rp <?php echo number_format($biaya_layanan, 0, ',', '.'); ?></span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold fs-5">Total Tagihan</span>
                                        <span class="fw-bold fs-3 text-purple-primary">
                                            Rp <?php echo number_format($total_final, 0, ',', '.'); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-5 ps-md-5 mt-4 mt-md-0">
                                    <input type="hidden" name="total_final" value="<?php echo $total_final; ?>">

                                    <button type="submit" class="btn btn-checkout w-100 mb-3">
                                        KONFIRMASI SEKARANG
                                    </button>

                                    <p class="text-center mb-0 small text-muted">
                                        <i class="fas fa-shield-alt me-1 text-purple-primary"></i> Transaksi Aman & Terenkripsi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="keranjang.php" class="text-decoration-none back-link small">
                            <i class="fas fa-arrow-left me-2"></i> KEMBALI KE KERANJANG
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const ambilToko = document.getElementById('ambil_toko');
        const dikirim = document.getElementById('dikirim');
        const boxEkspedisi = document.getElementById('box-ekspedisi');

        function toggleEkspedisi() {
            if (dikirim.checked) {
                boxEkspedisi.style.display = 'block';
            } else {
                boxEkspedisi.style.display = 'none';

                document.querySelectorAll('input[name="ekspedisi"]').forEach(radio => {
                    radio.checked = false;
                });

                document.getElementById('error-ekspedisi').style.display = 'none';
            }
        }

        ambilToko.addEventListener('change', toggleEkspedisi);
        dikirim.addEventListener('change', toggleEkspedisi);

        document.getElementById('formCheckout').addEventListener('submit', function(e) {
            let isValid = true;
            
            const metodePengambilan = document.querySelector('input[name="metode_pengambilan"]:checked');
            const errorMetodePengambilan = document.getElementById('error-metode-pengambilan');

            if (!metodePengambilan) {
                errorMetodePengambilan.style.display = 'block';
                isValid = false;
            } else {
                errorMetodePengambilan.style.display = 'none';
            }

            const ekspedisi = document.querySelector('input[name="ekspedisi"]:checked');
            const errorEkspedisi = document.getElementById('error-ekspedisi');

            if (dikirim.checked && !ekspedisi) {
                errorEkspedisi.style.display = 'block';
                isValid = false;
            } else {
                errorEkspedisi.style.display = 'none';
            }

            const pembayaran = document.querySelector('input[name="pembayaran"]:checked');
            const errorPembayaran = document.getElementById('error-pembayaran');

            if (!pembayaran) {
                errorPembayaran.style.display = 'block';
                isValid = false;
            } else {
                errorPembayaran.style.display = 'none';
            }

            if (!isValid) {
                e.preventDefault();

                const firstError =
                    !metodePengambilan ? errorMetodePengambilan :
                    (dikirim.checked && !ekspedisi) ? errorEkspedisi :
                    errorPembayaran;

                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        document.querySelectorAll('input[name="metode_pengambilan"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('error-metode-pengambilan').style.display = 'none';
            });
        });

        document.querySelectorAll('input[name="ekspedisi"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('error-ekspedisi').style.display = 'none';
            });
        });

        document.querySelectorAll('input[name="pembayaran"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('error-pembayaran').style.display = 'none';
            });
        });
    </script>
</body>
</html>