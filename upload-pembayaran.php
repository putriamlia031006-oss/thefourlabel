<?php
session_start();
require "koneksi.php";

// ======================
// VALIDASI LOGIN
// ======================
if(!isset($_SESSION['pelanggan'])){
    echo "
    <script>
        alert('Silahkan login terlebih dahulu');
        location='login.php';
    </script>
    ";
    exit;
}

// ======================
// AMBIL ID TRANSAKSI
// ======================
if(!isset($_GET['id'])){
    echo "
    <script>
        alert('ID transaksi tidak ditemukan');
        location='pesanan-saya.php';
    </script>
    ";
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// ======================
// QUERY TRANSAKSI
// ======================
$query = mysqli_query($koneksi,"
    SELECT * FROM tbl_transaksi
    WHERE id_transaksi='$id'
");

$data = mysqli_fetch_assoc($query);

// ======================
// VALIDASI TRANSAKSI
// ======================
if(!$data){
    echo "
    <script>
        alert('Transaksi tidak ditemukan');
        location='pesanan-saya.php';
    </script>
    ";
    exit;
}

// ======================
// AMBIL METODE PEMBAYARAN
// Prioritas:
// 1. Dari database tbl_transaksi.metode_pembayaran
// 2. Dari URL ?metode=...
// 3. Default Transfer Bank
// ======================
if(isset($data['metode_pembayaran']) && $data['metode_pembayaran'] != ''){
    $metode = $data['metode_pembayaran'];
} elseif(isset($_GET['metode']) && $_GET['metode'] != ''){
    $metode = $_GET['metode'];
} else {
    $metode = "Transfer Bank";
}

// Normalisasi agar aman beda tulisan
$metode_lower = strtolower(trim($metode));

// Label tampil
$metode_tampil = $metode;

if($metode_lower == "transfer bank" || $metode_lower == "transfer bank bca"){
    $metode_tampil = "Transfer Bank BCA";
} elseif($metode_lower == "e-wallet" || $metode_lower == "ewallet" || $metode_lower == "dana / ovo / gopay"){
    $metode_tampil = "E-Wallet";
} elseif($metode_lower == "cod"){
    $metode_tampil = "COD";
} elseif($metode_lower == "qris"){
    $metode_tampil = "QRIS";
} elseif($metode_lower == "indomaret / alfamart"){
    $metode_tampil = "Indomaret / Alfamart";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Upload Pembayaran | The Four Label</title>

    <link rel="stylesheet"
          href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="fontawesome/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap"
          rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
            background: linear-gradient(135deg,#f8f2ff,#efe4ff);
            min-height:100vh;
        }

        .payment-card{
            border:none;
            border-radius:28px;
            overflow:hidden;
            background:white;
            box-shadow:0 15px 35px rgba(155,89,182,0.15);
        }

        .payment-header{
            background: linear-gradient(135deg,#c084fc,#9b59b6);
            color:white;
            padding:40px;
            text-align:center;
        }

        .payment-header h2{
            font-weight:700;
            margin-bottom:10px;
        }

        .payment-header p{
            opacity:0.9;
            margin:0;
        }

        .section-title{
            font-size:14px;
            text-transform:uppercase;
            color:#999;
            margin-bottom:10px;
            font-weight:600;
        }

        .total-box{
            background:#faf5ff;
            border:2px dashed #d8b4fe;
            border-radius:18px;
            padding:25px;
            text-align:center;
        }

        .total-price{
            color:#8e44ad;
            font-size:35px;
            font-weight:700;
        }

        .payment-method-box{
            background:white;
            border:1px solid #eee;
            border-radius:18px;
            padding:20px;
        }

        .rekening-box{
            background:#faf5ff;
            border-left:5px solid #b57edc;
            padding:18px;
            border-radius:14px;
            margin-top:15px;
        }

        .rekening-title{
            color:#999;
            font-size:13px;
            text-transform:uppercase;
            font-weight:700;
        }

        .rekening-number{
            font-size:22px;
            font-weight:700;
            color:#6c3483;
        }

        .qris-box{
            background:#faf5ff;
            border:2px dashed #d8b4fe;
            border-radius:18px;
            padding:20px;
            margin-top:15px;
        }

        .cod-box{
            background:#f0fdf4;
            border-left:5px solid #16a34a;
            padding:18px;
            border-radius:14px;
            margin-top:15px;
        }

        .cod-box .rekening-title{
            color:#166534;
        }

        .cod-box .rekening-number{
            color:#166534;
        }

        .upload-box{
            border:2px dashed #c084fc;
            border-radius:18px;
            padding:35px;
            text-align:center;
            background:#fcf8ff;
            transition:0.3s;
        }

        .upload-box:hover{
            background:#f7efff;
        }

        .upload-icon{
            font-size:60px;
            color:#9b59b6;
            margin-bottom:15px;
        }

        .form-control,
        .form-select{
            border-radius:14px;
            padding:12px;
            border:1.5px solid #e9d8fd;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:#b57edc;
            box-shadow:0 0 0 0.2rem rgba(181,126,220,0.2);
        }

        .btn-payment{
            background: linear-gradient(135deg,#c084fc,#9b59b6);
            border:none;
            color:white;
            padding:15px;
            border-radius:14px;
            font-weight:700;
            transition:0.3s;
        }

        .btn-payment:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(155,89,182,0.25);
            color:white;
        }

        .badge-status{
            background:#fff3cd;
            color:#856404;
            padding:8px 15px;
            border-radius:50px;
            font-size:13px;
            font-weight:600;
        }

        .btn-back{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:#f3e8ff;
            color:#6c3483;
            border:none;
            border-radius:14px;
            padding:10px 16px;
            text-decoration:none;
            font-weight:700;
            margin-bottom:20px;
        }

        .btn-back:hover{
            background:#e9d5ff;
            color:#6c3483;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <a href="pesanan-saya.php" class="btn-back">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Pesanan
            </a>

            <div class="card payment-card">

                <div class="payment-header">
                    <h2>Upload Pembayaran</h2>
                    <p>Selesaikan pembayaran untuk memproses pesanan Anda</p>
                </div>

                <div class="card-body p-4 p-lg-5">

                    <div class="mb-4 text-center">
                        <span class="badge-status">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="total-box mb-4">
                        <div class="section-title">
                            Total Pembayaran
                        </div>

                        <div class="total-price">
                            Rp <?= number_format($data['total_harga'],0,',','.'); ?>
                        </div>
                    </div>

                    <div class="payment-method-box mb-4">

                        <div class="section-title">
                            Informasi Pembayaran
                        </div>

                        <?php if($metode_tampil == "Transfer Bank BCA"){ ?>

                            <div class="rekening-box">
                                <div class="rekening-title">Bank BCA</div>
                                <div class="rekening-number">1234567890</div>
                                <small>a/n THE FOUR LABEL</small>
                            </div>

                        <?php } elseif($metode_tampil == "E-Wallet"){ ?>

                            <div class="rekening-box">
                                <div class="rekening-title">E-Wallet</div>
                                <div class="rekening-number">081234567890</div>
                                <small>DANA / OVO / GOPAY a/n THE FOUR LABEL</small>
                            </div>

                        <?php } elseif($metode_tampil == "QRIS"){ ?>

                            <div class="qris-box text-center">
                                <div class="rekening-title mb-3">QRIS The Four Label</div>

                                <img src="image/qris.png"
                                     class="img-fluid rounded shadow"
                                     width="250"
                                     alt="QRIS The Four Label">

                                <p class="text-muted small mt-3 mb-0">
                                    Scan QRIS untuk melakukan pembayaran.
                                </p>
                            </div>

                        <?php } elseif($metode_tampil == "Indomaret / Alfamart"){ ?>

                            <div class="rekening-box">
                                <div class="rekening-title">Kode Pembayaran Retail</div>
                                <div class="rekening-number">
                                    INV<?= $id; ?><?= rand(100,999); ?>
                                </div>
                                <small>Tunjukkan kode ini ke kasir Indomaret / Alfamart.</small>
                            </div>

                        <?php } elseif($metode_tampil == "COD"){ ?>

                            <div class="cod-box">
                                <div class="rekening-title">COD</div>
                                <div class="rekening-number">Bayar di Tempat</div>
                                <small>Pembayaran dilakukan saat pesanan diterima oleh customer.</small>
                            </div>

                        <?php } else { ?>

                            <div class="rekening-box">
                                <div class="rekening-title">Metode Pembayaran</div>
                                <div class="rekening-number"><?= htmlspecialchars($metode_tampil); ?></div>
                                <small>Silahkan ikuti instruksi pembayaran dari admin.</small>
                            </div>

                        <?php } ?>

                    </div>

                    <form method="POST"
                          enctype="multipart/form-data">

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">
                                Metode Pembayaran
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?= htmlspecialchars($metode_tampil); ?>"
                                   readonly>

                            <input type="hidden"
                                   name="metode"
                                   value="<?= htmlspecialchars($metode_tampil); ?>">

                        </div>

                        <?php if($metode_tampil != "COD"){ ?>

                            <div class="mb-4">

                                <label class="fw-semibold mb-3">
                                    Upload Bukti Pembayaran
                                </label>

                                <div class="upload-box">

                                    <i class="fa fa-cloud-upload-alt upload-icon"></i>

                                    <p class="text-muted mb-3">
                                        Upload screenshot bukti pembayaran
                                    </p>

                                    <input type="file"
                                           name="bukti"
                                           class="form-control"
                                           accept="image/*"
                                           required>

                                </div>

                            </div>

                        <?php } else { ?>

                            <div class="alert alert-success rounded-4">
                                <i class="fa fa-circle-info me-2"></i>
                                Metode COD tidak perlu upload bukti pembayaran. Klik tombol di bawah untuk mengonfirmasi pesanan COD.
                            </div>

                        <?php } ?>

                        <button type="submit"
                                name="upload"
                                class="btn btn-payment w-100">

                            <i class="fa fa-paper-plane me-2"></i>

                            <?= ($metode_tampil == "COD") ? "Konfirmasi Pesanan COD" : "Kirim Pembayaran"; ?>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>

<?php

// ======================
// PROSES UPLOAD
// ======================
if(isset($_POST['upload'])){

    $metode_post = mysqli_real_escape_string($koneksi, $_POST['metode']);

    $folder = "bukti/";

    if(!is_dir($folder)){
        mkdir($folder);
    }

    if($metode_post == "COD"){

        $insertPembayaran = mysqli_query($koneksi,"
            INSERT INTO tbl_pembayaran
            (
                id_transaksi,
                jenis_pembayaran,
                metode_pembayaran,
                nominal,
                bukti_transfer,
                status_verifikasi,
                tanggal_bayar
            )
            VALUES
            (
                '$id',
                'COD',
                '$metode_post',
                '".$data['total_harga']."',
                '',
                'pending',
                NOW()
            )
        ");

        $updateTransaksi = mysqli_query($koneksi,"
            UPDATE tbl_transaksi
            SET
                status_pembayaran='COD',
                status_transaksi='Proses'
            WHERE id_transaksi='$id'
        ");

    }else{

        if(!isset($_FILES['bukti']) || $_FILES['bukti']['name'] == ''){
            echo "
            <script>
                alert('Silahkan upload bukti pembayaran');
                history.back();
            </script>
            ";
            exit;
        }

        $nama_file = time()."_".basename($_FILES['bukti']['name']);
        $tmp = $_FILES['bukti']['tmp_name'];

        $upload = move_uploaded_file(
            $tmp,
            $folder.$nama_file
        );

        if(!$upload){
            echo "
            <script>
                alert('Gagal upload bukti pembayaran');
                history.back();
            </script>
            ";
            exit;
        }

        $insertPembayaran = mysqli_query($koneksi,"
            INSERT INTO tbl_pembayaran
            (
                id_transaksi,
                jenis_pembayaran,
                metode_pembayaran,
                nominal,
                bukti_transfer,
                status_verifikasi,
                tanggal_bayar
            )
            VALUES
            (
                '$id',
                'transfer',
                '$metode_post',
                '".$data['total_harga']."',
                '$nama_file',
                'pending',
                NOW()
            )
        ");

        $updateTransaksi = mysqli_query($koneksi,"
            UPDATE tbl_transaksi
            SET
                status_pembayaran='menunggu verifikasi',
                status_transaksi='Pending'
            WHERE id_transaksi='$id'
        ");

    }

    if(!$insertPembayaran || !$updateTransaksi){
        echo "
        <script>
            alert('Gagal menyimpan pembayaran: ".mysqli_error($koneksi)."');
            history.back();
        </script>
        ";
        exit;
    }

    unset($_SESSION['keranjang']);

    echo "
    <script>
        alert('Pembayaran berhasil dikirim');
        location='pesanan-saya.php';
    </script>
    ";

}
?>