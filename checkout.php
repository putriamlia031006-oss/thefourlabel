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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Premium | Fashion Gassspol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            color: #2d3436;
            background-color: #f0f4f8; /* Biru sangat muda */
        }

        .checkout-card { 
            border: none; 
            border-radius: 16px; 
            background: #ffffff;
            transition: all 0.3s ease;
        }
        
        .form-control {
            border: 1.5px solid #e1e8ed;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .step-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .step-number { 
            width: 32px; height: 32px; 
            background: #0d6efd; color: white; /* Biru */
            border-radius: 8px; display: inline-flex; 
            align-items: center; justify-content: center; 
            margin-right: 12px; font-weight: 700;
        }

        /* Styling untuk Radio Card */
        .selection-card {
            cursor: pointer;
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 18px;
            transition: all 0.2s ease;
            height: 100%;
            display: block;
            position: relative;
        }

        .selection-card:hover {
            border-color: #0d6efd;
            background-color: #f8fbff;
        }

        /* Border Colors for Payment Methods */
        .pay-bca { border-left: 5px solid #005aa1; }
        .pay-mandiri { border-left: 5px solid #ffc107; }
        .pay-ewallet { border-left: 5px solid #00d1ff; }
        .pay-qris { border-left: 5px solid #ea1d2c; }
        .pay-retail { border-left: 5px solid #f37021; }
        .pay-cod { border-left: 5px solid #2d3436; }

        .form-check-input:checked + .selection-card {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }

        .prod-img {
            width: 70px; height: 70px;
            object-fit: cover;
            border-radius: 12px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .btn-checkout {
            background: #0d6efd;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .btn-checkout:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        .summary-box {
            background: #ffffff;
            border-top: 4px solid #0d6efd; /* Biru */
            border-radius: 16px; 
        }

        .text-blue-primary {
            color: #0d6efd !important;
        }

        .error-msg {
            display: none;
            color: #dc3545;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
            background: #fff8f8;
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid #f8d7da;
        }
    </style>
</head>
<body>
    <?php require "navbar-checkout.php"; ?>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Konfirmasi Pesanan</h2>
                <p class="text-muted">Lengkapi data di bawah ini untuk menyelesaikan transaksi.</p>
            </div>
        </div>
        
        <form action="proses-checkout.php" method="POST" id="formCheckout">
            <div class="row justify-content-center">
                <div class="col-lg-10"> 
                    
                    <div class="card checkout-card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">1</span>
                                <h5 class="fw-bold mb-0">Informasi Pengiriman</h5>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Penerima</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
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
                                    <textarea name="alamat" class="form-control" rows="1" placeholder="Nama jalan, nomor rumah, RT/RW" required style="min-height: 48px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card checkout-card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">2</span>
                                <h5 class="fw-bold mb-0">Opsi Pengiriman</h5>
                            </div>
                            <p class="small text-muted mb-3 italic">* Silahkan pilih salah satu jasa pengiriman</p>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="ekspedisi" id="jne" value="JNE">
                                    <label for="jne" class="selection-card">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="fw-bold text-primary d-block">JNE Reguler</span>
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
                                                <span class="fw-bold text-danger d-block">J&T Express</span>
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
                                                <span class="fw-bold d-block" style="color: #6d21bd;">SiCepat Reg</span>
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
                                                <span class="fw-bold text-blue-primary d-block">Instant/Sameday</span>
                                                <small class="text-muted">6-8 Jam</small>
                                            </div>
                                            <i class="fas fa-motorcycle text-muted"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div id="error-ekspedisi" class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> Silahkan pilih jasa pengiriman terlebih dahulu</div>
                        </div>
                    </div>

                    <div class="card checkout-card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">3</span>
                                <h5 class="fw-bold mb-0">Metode Pembayaran</h5>
                            </div>
                            <p class="small text-muted mb-3 italic">* Silahkan pilih metode pembayaran</p>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="bca" value="Transfer Bank BCA">
                                    <label for="bca" class="selection-card pay-bca">
                                        <span class="fw-bold d-block" style="color: #005aa1;">Bank BCA</span>
                                        <small class="text-muted">Transfer / M-Banking</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="mandiri" value="Transfer Bank Mandiri">
                                    <label for="mandiri" class="selection-card pay-mandiri">
                                        <span class="fw-bold d-block" style="color: #c49100;">Bank Mandiri</span>
                                        <small class="text-muted">Transfer / Livin</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="qris" value="QRIS">
                                    <label for="qris" class="selection-card pay-qris">
                                        <span class="fw-bold d-block text-danger">QRIS</span>
                                        <small class="text-muted">Scan Semua Aplikasi</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="ewallet" value="Dana / OVO / Gopay">
                                    <label for="ewallet" class="selection-card pay-ewallet">
                                        <span class="fw-bold d-block" style="color: #00b4db;">E-Wallet</span>
                                        <small class="text-muted">Dana, OVO, Gopay</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="retail" value="Indomaret / Alfamart">
                                    <label for="retail" class="selection-card pay-retail">
                                        <span class="fw-bold d-block" style="color: #f37021;">Gerai Retail</span>
                                        <small class="text-muted">Indomaret/Alfamart</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="radio" class="form-check-input d-none" name="pembayaran" id="cod" value="COD">
                                    <label for="cod" class="selection-card pay-cod">
                                        <span class="fw-bold d-block">COD</span>
                                        <small class="text-muted">Bayar di Tempat</small>
                                    </label>
                                </div>
                            </div>
                            <div id="error-pembayaran" class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> Silahkan pilih metode pembayaran terlebih dahulu</div>
                        </div>
                    </div>

                    <div class="card checkout-card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="step-header">
                                <span class="step-number">4</span>
                                <h5 class="fw-bold mb-0">Review Produk</h5>
                            </div>
                            <?php foreach ($_SESSION['keranjang'] as $key => $item): ?>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="image/<?php echo $item['foto']; ?>" class="prod-img" data-bs-toggle="modal" data-bs-target="#modalGambar<?php echo $key; ?>">
                                
                                <div class="ms-4 flex-grow-1">
                                    <h6 class="mb-1 fw-bold"><?php echo $item['nama']; ?></h6>
                                    <span class="text-muted small"><?php echo $item['jumlah']; ?> unit x Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                                </div>
                                <div class="text-end fw-bold text-blue-primary">
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
                            <h5 class="fw-bold mb-4">Total Pembayaran</h5>
                            <div class="row align-items-center">
                                <div class="col-md-7 border-end">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal Produk</span>
                                        <span class="fw-semibold">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Biaya Pengiriman</span>
                                        <span class="text-primary fw-bold">GRATIS</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Biaya Layanan</span>
                                        <span class="fw-semibold">Rp <?php echo number_format($biaya_layanan, 0, ',', '.'); ?></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold fs-5">Total Tagihan</span>
                                        <span class="fw-bold fs-3 text-blue-primary">Rp <?php echo number_format($total_final, 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-5 ps-md-5 mt-4 mt-md-0">
                                    <input type="hidden" name="total_final" value="<?php echo $total_final; ?>">
                                    <button type="submit" class="btn btn-primary btn-checkout w-100 mb-3 shadow">
                                        KONFIRMASI SEKARANG
                                    </button>
                                    <p class="text-center mb-0 small text-muted">
                                        <i class="fas fa-shield-alt me-1 text-primary"></i> Transaksi Aman & Terenkripsi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="keranjang.php" class="text-decoration-none text-muted fw-bold small">
                            <i class="fas fa-arrow-left me-2"></i> KEMBALI KE KERANJANG
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('formCheckout').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Cek Ekspedisi
            const ekspedisi = document.querySelector('input[name="ekspedisi"]:checked');
            const errorEkspedisi = document.getElementById('error-ekspedisi');
            if (!ekspedisi) {
                errorEkspedisi.style.display = 'block';
                isValid = false;
            } else {
                errorEkspedisi.style.display = 'none';
            }

            // Cek Pembayaran
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
                const firstError = !ekspedisi ? errorEkspedisi : errorPembayaran;
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        // Event listener untuk menghilangkan pesan error saat pilihan diklik
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