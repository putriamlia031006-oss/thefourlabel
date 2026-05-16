<?php
require "session.php";
require "../koneksi.php";

// 1. Validasi ID
if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 2. Ambil Data Transaksi
$query = mysqli_query($koneksi, "SELECT t.*, c.nama_customer 
                                FROM tbl_transaksi t 
                                JOIN tbl_customer c ON t.id_customer = c.id_customer 
                                WHERE t.id_transaksi = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    header("Location: transaksi.php");
    exit;
}

// 3. Logika PHP
$pesan_sukses = "";

if (isset($_POST['btn_update'])) {
    $status_baru = $_POST['status_transaksi'];
    $update = mysqli_query($koneksi, "UPDATE tbl_transaksi SET status_transaksi = '$status_baru' WHERE id_transaksi = '$id'");
    if ($update) {
        $pesan_sukses = "update";
    }
}

if (isset($_POST['btn_hapus'])) {
    mysqli_query($koneksi, "DELETE FROM tbl_detail_transaksi WHERE id_transaksi = '$id'");
    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_transaksi WHERE id_transaksi = '$id'");
    if ($hapus) {
        $pesan_sukses = "delete";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi | Fashion Gassspol</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* DISAMAKAN DENGAN HALAMAN TRANSAKSI */
        body { 
            background: #f4f7fe; 
            font-family: 'Poppins', sans-serif; 
            color: #333; 
        }

        .card-edit { 
            border: none; 
            border-radius: 15px; /* Sesuaikan radius dengan table-container */
            box-shadow: 0 10px 30px rgba(0,0,0,.05); 
            overflow: hidden; 
            background: #fff;
        }

        .header-gradient { 
            background-color: #3674B5; /* Samakan dengan header tabel transaksi */
            color: white; 
            padding: 30px; 
        }

        .form-control-lg, .form-select-lg { 
            border-radius: 10px; 
            font-size: 0.95rem; 
            border: 1px solid #dee2e6; 
            font-family: 'Poppins', sans-serif;
        }

        .form-control-lg:focus { 
            border-color: #3674B5; 
            box-shadow: none; 
        }

        .btn-custom { 
            border-radius: 10px; 
            padding: 10px 20px; 
            font-weight: 500; 
            transition: all 0.3s; 
        }

        .btn-custom:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        }

        .text-success-custom {
            color: #198754;
            font-weight: 700;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 animate__animated animate__fadeIn">
            
            <div class="card card-edit">
                <div class="header-gradient">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit fa-2x me-3"></i>
                        <div>
                            <h3 class="mb-0 fw-bold" style="letter-spacing: -0.5px;">Update Transaksi</h3>
                            <p class="mb-0 opacity-75 small">ID Transaksi: #TRX-<?= $data['id_transaksi']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <div class="row mb-4 bg-light p-3 rounded-3 g-0">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Customer</small>
                            <span class="fw-semibold"><?= $data['nama_customer']; ?></span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Total Pembayaran</small>
                            <span class="text-success-custom fs-5">Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></span>
                        </div>
                    </div>

                    <form action="" method="POST" id="formUpdate">
                        <div class="mb-4">
                            <label class="form-label fw-600 small text-muted text-uppercase">Ubah Status Pesanan</label>
                            <select name="status_transaksi" class="form-select form-select-lg">
                                <option value="Pending" <?= ($data['status_transaksi'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Proses" <?= ($data['status_transaksi'] == 'Proses') ? 'selected' : ''; ?>>Proses</option>
                                <option value="Selesai" <?= ($data['status_transaksi'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Dibatalkan" <?= ($data['status_transaksi'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <button type="submit" name="btn_update" class="btn btn-primary btn-custom w-100 shadow-sm" style="background-color: #3674B5; border: none;">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" onclick="hapusData()" class="btn btn-outline-danger btn-custom w-100">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>
                                <input type="submit" name="btn_hapus" id="submit_hapus" style="display:none;">
                            </div>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="transaksi.php" class="text-decoration-none text-muted small">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapusData() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data transaksi akan dihapus selamanya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('submit_hapus').click();
            }
        })
    }

    <?php if($pesan_sukses == "update"): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Status transaksi telah diperbarui.',
            showConfirmButton: false,
            timer: 2000
        }).then(() => { window.location='transaksi.php'; });
    <?php elseif($pesan_sukses == "delete"): ?>
        Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data transaksi berhasil dihapus.',
            showConfirmButton: false,
            timer: 2000
        }).then(() => { window.location='transaksi.php'; });
    <?php endif; ?>
</script>

</body>
</html>