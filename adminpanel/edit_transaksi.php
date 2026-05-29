<?php
require "session.php";
require "../koneksi.php";

// Validasi ID
if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil Data Transaksi
$query = mysqli_query($koneksi, "
    SELECT t.*, p.nama_pelanggan 
    FROM tbl_transaksi t 
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan 
    WHERE t.id_transaksi = '$id'
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_array($query);

if (!$data) {
    header("Location: transaksi.php");
    exit;
}

// Logika Update dan Hapus
$pesan_sukses = "";

if (isset($_POST['btn_update'])) {
    $status_baru = mysqli_real_escape_string($koneksi, $_POST['status_transaksi']);

    $update = mysqli_query($koneksi, "
        UPDATE tbl_transaksi 
        SET status_transaksi = '$status_baru' 
        WHERE id_transaksi = '$id'
    ");

    if ($update) {
        $pesan_sukses = "update";
    } else {
        die("Update gagal: " . mysqli_error($koneksi));
    }
}

if (isset($_POST['btn_hapus'])) {
    mysqli_query($koneksi, "DELETE FROM tbl_detail_transaksi WHERE id_transaksi = '$id'");

    $hapus = mysqli_query($koneksi, "
        DELETE FROM tbl_transaksi 
        WHERE id_transaksi = '$id'
    ");

    if ($hapus) {
        $pesan_sukses = "delete";
    } else {
        die("Hapus gagal: " . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi | The Four Label</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4c1d95;
            --primary-light: #a78bfa;
            --primary-soft: #ede9fe;
            --bg-body: #f7f3ff;
            --text-dark: #261447;
            --text-muted: #7c728f;
            --white: #ffffff;
        }

        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        * {
            box-sizing: border-box;
        }

        body { 
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 32%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.18), transparent 28%),
                linear-gradient(135deg, #fbfaff 0%, #f3ecff 45%, #eee7ff 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .page-wrapper {
            padding-top: 45px;
            padding-bottom: 70px;
        }

        .card-edit { 
            border: none; 
            border-radius: 28px;
            box-shadow: 0 14px 32px rgba(76, 29, 149, 0.10); 
            overflow: hidden; 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(124, 58, 237, 0.09);
        }

        .header-gradient { 
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
            color: white; 
            padding: 32px; 
            position: relative;
            overflow: hidden;
        }

        .header-gradient::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -60px;
            top: -70px;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.24);
            padding: 7px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .info-box {
            background: #faf5ff;
            border: 1px solid rgba(124, 58, 237, 0.10);
            border-radius: 20px;
            padding: 18px;
        }

        .info-label {
            color: var(--text-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.6px;
            margin-bottom: 4px;
        }

        .info-value {
            color: var(--primary-dark);
            font-weight: 800;
        }

        .text-success-custom {
            color: #15803d;
            font-weight: 800;
        }

        .form-label {
            font-weight: 800;
            color: var(--primary-dark);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-select-lg { 
            border-radius: 14px; 
            font-size: 0.95rem; 
            border: 1px solid rgba(124, 58, 237, 0.14); 
            font-family: 'Poppins', sans-serif;
            padding: 13px 16px;
            background-color: #fbfaff;
        }

        .form-select-lg:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.13) !important;
        }

        .btn-custom { 
            border-radius: 14px; 
            padding: 12px 20px; 
            font-weight: 800; 
            transition: all 0.3s; 
        }

        .btn-save {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            border: none;
            color: white;
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.20);
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: white;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        .back-link {
            color: var(--text-muted);
            font-weight: 700;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .swal2-popup {
            border-radius: 22px !important;
        }
    </style>
</head>

<body>

<?php require "navbar.php"; ?>

<div class="container page-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-7 animate__animated animate__fadeIn">
            
            <div class="card card-edit">
                <div class="header-gradient">
                    <div class="header-content">
                        <div class="brand-badge">
                            <i class="fas fa-shirt"></i>
                            Konveksi The Four Label
                        </div>

                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-0 fw-bold">Update Transaksi</h3>
                                <p class="mb-0 opacity-75 small">
                                    ID Transaksi: #TRX-<?= $data['id_transaksi']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <div class="row mb-4 info-box g-0">
                        <div class="col-6">
                            <div class="info-label">Customer</div>
                            <span class="info-value"><?= $data['nama_pelanggan']; ?></span>
                        </div>

                        <div class="col-6 text-end">
                            <div class="info-label">Total Pembayaran</div>
                            <span class="text-success-custom fs-5">
                                Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4 info-box g-0">
                        <div class="col-6">
                            <div class="info-label">Tanggal Transaksi</div>
                            <span class="info-value">
                                <?= date('d M Y', strtotime($data['tanggal_transaksi'])); ?>
                            </span>
                        </div>

                        <div class="col-6 text-end">
                            <div class="info-label">Jumlah Produk</div>
                            <span class="info-value">
                                <?= $data['total_produk']; ?> Item
                            </span>
                        </div>
                    </div>

                    <form action="" method="POST" id="formUpdate">
                        <div class="mb-4">
                            <label class="form-label">Ubah Status Pesanan</label>

                            <select name="status_transaksi" class="form-select form-select-lg" required>
                                <option value="Pending" <?= ($data['status_transaksi'] == 'Pending') ? 'selected' : ''; ?>>
                                    Pending
                                </option>
                                <option value="Proses" <?= ($data['status_transaksi'] == 'Proses') ? 'selected' : ''; ?>>
                                    Proses
                                </option>
                                <option value="Selesai" <?= ($data['status_transaksi'] == 'Selesai') ? 'selected' : ''; ?>>
                                    Selesai
                                </option>
                                <option value="Dibatalkan" <?= ($data['status_transaksi'] == 'Dibatalkan') ? 'selected' : ''; ?>>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <button type="submit" name="btn_update" class="btn btn-custom btn-save w-100">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button type="button" onclick="hapusData()" class="btn btn-custom btn-delete w-100">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>

                                <input type="submit" name="btn_hapus" id="submit_hapus" style="display:none;">
                            </div>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="transaksi.php" class="text-decoration-none back-link small">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Transaksi
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function hapusData() {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data transaksi dan detail transaksi akan dihapus selamanya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#7c3aed',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('submit_hapus').click();
            }
        });
    }

    <?php if($pesan_sukses == "update"): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Status transaksi telah diperbarui.',
            confirmButtonColor: '#7c3aed',
            showConfirmButton: false,
            timer: 2000
        }).then(() => { 
            window.location='transaksi.php'; 
        });
    <?php elseif($pesan_sukses == "delete"): ?>
        Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data transaksi berhasil dihapus.',
            confirmButtonColor: '#7c3aed',
            showConfirmButton: false,
            timer: 2000
        }).then(() => { 
            window.location='transaksi.php'; 
        });
    <?php endif; ?>
</script>

</body>
</html>