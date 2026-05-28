```php id="w1op3m"
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
$id = $_GET['id'];

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
// AMBIL METODE
// ======================
$metode = $_GET['metode'] ?? 'Transfer Bank BCA';

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Upload Pembayaran
    </title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet"
          href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="fontawesome/css/all.min.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap"
          rel="stylesheet">

    <style>

        body{

            font-family:'Inter',sans-serif;

            background:
            linear-gradient(135deg,#f8f2ff,#efe4ff);

            min-height:100vh;

        }

        .payment-card{

            border:none;

            border-radius:28px;

            overflow:hidden;

            background:white;

            box-shadow:
            0 15px 35px rgba(155,89,182,0.15);

        }

        .payment-header{

            background:
            linear-gradient(135deg,#c084fc,#9b59b6);

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

        }

        .rekening-number{

            font-size:22px;

            font-weight:700;

            color:#6c3483;

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

            box-shadow:
            0 0 0 0.2rem rgba(181,126,220,0.2);

        }

        .btn-payment{

            background:
            linear-gradient(135deg,#c084fc,#9b59b6);

            border:none;

            color:white;

            padding:15px;

            border-radius:14px;

            font-weight:700;

            transition:0.3s;

        }

        .btn-payment:hover{

            transform:translateY(-2px);

            box-shadow:
            0 10px 20px rgba(155,89,182,0.25);

        }

        .badge-status{

            background:#fff3cd;

            color:#856404;

            padding:8px 15px;

            border-radius:50px;

            font-size:13px;

            font-weight:600;

        }

    </style>

</head>
<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card payment-card">

                <!-- HEADER -->
                <div class="payment-header">

                    <h2>
                        Upload Pembayaran
                    </h2>

                    <p>
                        Selesaikan pembayaran untuk memproses pesanan Anda
                    </p>

                </div>

                <div class="card-body p-4 p-lg-5">

                    <!-- STATUS -->
                    <div class="mb-4 text-center">

                        <span class="badge-status">

                            Menunggu Pembayaran

                        </span>

                    </div>

                    <!-- TOTAL -->
                    <div class="total-box mb-4">

                        <div class="section-title">

                            Total Pembayaran

                        </div>

                        <div class="total-price">

                            Rp <?= number_format($data['total_harga'],0,',','.'); ?>

                        </div>

                    </div>

                    <!-- INFORMASI PEMBAYARAN -->
                    <div class="payment-method-box mb-4">

                        <div class="section-title">

                            Informasi Pembayaran

                        </div>

                        <!-- BCA -->
                        <?php if($metode == "Transfer Bank BCA"){ ?>

                            <div class="rekening-box">

                                <div class="rekening-title">
                                    Bank BCA
                                </div>

                                <div class="rekening-number">
                                    1234567890
                                </div>

                                <small>
                                    a/n THE FOUR LABEL
                                </small>

                            </div>

                        <?php } ?>

                        <!-- MANDIRI -->
                        <?php if($metode == "Transfer Bank Mandiri"){ ?>

                            <div class="rekening-box">

                                <div class="rekening-title">
                                    Bank Mandiri
                                </div>

                                <div class="rekening-number">
                                    9876543210
                                </div>

                                <small>
                                    a/n THE FOUR LABEL
                                </small>

                            </div>

                        <?php } ?>

                        <!-- QRIS -->
                        <?php if($metode == "QRIS"){ ?>

                            <div class="text-center mt-3">

                                <img src="image/qris.png"
                                     class="img-fluid rounded shadow"
                                     width="250">

                            </div>

                        <?php } ?>

                        <!-- EWALLET -->
                        <?php if($metode == "Dana / OVO / Gopay"){ ?>

                            <div class="rekening-box">

                                <div class="rekening-title">
                                    E-Wallet
                                </div>

                                <div class="rekening-number">
                                    081234567890
                                </div>

                                <small>
                                    Dana / OVO / Gopay
                                </small>

                            </div>

                        <?php } ?>

                        <!-- RETAIL -->
                        <?php if($metode == "Indomaret / Alfamart"){ ?>

                            <div class="rekening-box">

                                <div class="rekening-title">
                                    Kode Pembayaran Retail
                                </div>

                                <div class="rekening-number">
                                    INV<?= $id; ?><?= rand(100,999); ?>
                                </div>

                                <small>
                                    Tunjukkan kode ini ke kasir
                                </small>

                            </div>

                        <?php } ?>

                    </div>

                    <!-- FORM -->
                    <form method="POST"
                          enctype="multipart/form-data">

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Metode Pembayaran

                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?= $metode; ?>"
                                   readonly>

                            <input type="hidden"
                                   name="metode"
                                   value="<?= $metode; ?>">

                        </div>

                        <!-- UPLOAD -->
                        <?php if($metode != "COD"){ ?>

                        <div class="mb-4">

                            <label class="fw-semibold mb-3">

                                Upload Bukti Pembayaran

                            </label>

                            <div class="upload-box">

                                <i class="fa fa-cloud-upload-alt upload-icon"></i>

                                <p class="text-muted mb-3">

                                    Upload screenshot bukti transfer pembayaran

                                </p>

                                <input type="file"
                                       name="bukti"
                                       class="form-control"
                                       required>

                            </div>

                        </div>

                        <?php } ?>

                        <!-- BUTTON -->
                        <button type="submit"
                                name="upload"
                                class="btn btn-payment w-100">

                            <i class="fa fa-paper-plane me-2"></i>

                            Kirim Pembayaran

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

    $metode = $_POST['metode'];

    $folder = "bukti/";

    // CEK FOLDER
    if(!is_dir($folder)){

        mkdir($folder);

    }

    // ======================
    // JIKA COD
    // ======================
    if($metode == "COD"){

        mysqli_query($koneksi,"
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
            '$metode',
            '".$data['total_harga']."',
            '',
            'pending',
            NOW()
        )
        ");

        mysqli_query($koneksi,"
        UPDATE tbl_transaksi
        SET
            status_pembayaran='COD',
            status_transaksi='diproses'
        WHERE id_transaksi='$id'
        ");

    }else{

        // ======================
        // UPLOAD FILE
        // ======================
        $nama_file = time()."_".$_FILES['bukti']['name'];

        $tmp = $_FILES['bukti']['tmp_name'];

        move_uploaded_file(
            $tmp,
            $folder.$nama_file
        );

        // ======================
        // INSERT PEMBAYARAN
        // ======================
        mysqli_query($koneksi,"
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
            '$metode',
            '".$data['total_harga']."',
            '$nama_file',
            'pending',
            NOW()
        )
        ");

        // ======================
        // UPDATE TRANSAKSI
        // ======================
        mysqli_query($koneksi,"
        UPDATE tbl_transaksi
        SET
            status_pembayaran='menunggu verifikasi',
            status_transaksi='pending'
        WHERE id_transaksi='$id'
        ");

    }

    // ======================
    // HAPUS KERANJANG
    // ======================
    unset($_SESSION['keranjang']);

    echo "
    <script>

        alert('Pembayaran berhasil dikirim');

        location='pesanan-saya.php';

    </script>
    ";

}
?>
```
