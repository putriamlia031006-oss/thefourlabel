<?php

session_start();

require "koneksi.php";

echo '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Pesanan...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
        }
        .loading-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.5s ease-in-out;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #e0e0e0;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        .loading-text {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        .loading-subtext {
            color: #777;
            font-size: 14px;
            margin-top: 8px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10deg); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="loading-container">
    <div class="spinner"></div>
    <p class="loading-text">Sedang Memproses Pesanan Anda</p>
    <p class="loading-subtext">Mohon tunggu sebentar, jangan tutup halaman ini.</p>
</div>
';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // =========================
    // AMBIL DATA FORM
    // =========================
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nomor_hp     = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email_input  = mysqli_real_escape_string($koneksi, $_POST['email']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $total_final  = mysqli_real_escape_string($koneksi, $_POST['total_final']);
    
    $tanggal_transaksi = date("Y-m-d");
    $status_transaksi  = "Pending";

    // =========================
    // VALIDASI KERANJANG
    // =========================
    if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Keranjang Kosong',
            text: 'Silakan pilih produk terlebih dahulu',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location = 'produk.php';
        });
        </script>
        ";
        exit;
    }

    // =========================
    // CEK CUSTOMER BERDASARKAN EMAIL
    // =========================
    $cekCustomer = mysqli_query($koneksi, "SELECT id_pelanggan FROM pelanggan WHERE email_pelanggan='$email_input'");

    if(mysqli_num_rows($cekCustomer) > 0){
        // Jika pelanggan sudah terdaftar, ambil ID-nya lalu update datanya
        $customerData = mysqli_fetch_assoc($cekCustomer);
        $id_pelanggan = $customerData['id_pelanggan'];

        mysqli_query($koneksi, "UPDATE pelanggan SET 
            nama_pelanggan='$nama_pembeli', 
            telepon_pelanggan='$nomor_hp', 
            alamat_pelanggan='$alamat' 
            WHERE id_pelanggan='$id_pelanggan'");
    } else {
        // Jika pelanggan baru, buat akun baru.
        // password_pelanggan diisi string kosong agar tidak error karena 'Not Null' di database kamu
        $password_default = ""; 

        mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, email_pelanggan, password_pelanggan, telepon_pelanggan, alamat_pelanggan) 
            VALUES ('$nama_pembeli', '$email_input', '$password_default', '$nomor_hp', '$alamat')");
        $id_pelanggan = mysqli_insert_id($koneksi);
    }

    // =========================
    // HITUNG TOTAL QTY
    // =========================
    $total_qty = 0;
    foreach($_SESSION['keranjang'] as $item){
        $total_qty += $item['jumlah'];
    }

    // =========================
    // INSERT TRANSAKSI (Sudah Diperbaiki Menggunakan id_customer)
    // =========================
    $queryTransaksi = "INSERT INTO tbl_transaksi (id_pelanggan, tanggal_transaksi, status_transaksi, total_produk, total_harga) 
                       VALUES ('$id_pelanggan', '$tanggal_transaksi', '$status_transaksi', '$total_qty', '$total_final')";

    if(mysqli_query($koneksi, $queryTransaksi)){
        $id_transaksi = mysqli_insert_id($koneksi);
        $_SESSION['last_id'] = $id_transaksi;

        // =========================
        // INSERT DETAIL TRANSAKSI
        // =========================
        foreach($_SESSION['keranjang'] as $item){
            $id_produk = $item['id'];
            $jumlah    = $item['jumlah'];

            $ukuran  = !empty($item['ukuran'])  ? "'".mysqli_real_escape_string($koneksi, $item['ukuran'])."'"  : "NULL";
            $warna   = !empty($item['warna'])   ? "'".mysqli_real_escape_string($koneksi, $item['warna'])."'"   : "NULL";
            $bahan   = !empty($item['bahan'])   ? "'".mysqli_real_escape_string($koneksi, $item['bahan'])."'"   : "NULL";
            $desain  = !empty($item['desain'])  ? "'".mysqli_real_escape_string($koneksi, $item['desain'])."'"  : "NULL";
            $catatan = !empty($item['catatan']) ? "'".mysqli_real_escape_string($koneksi, $item['catatan'])."'" : "NULL";

            $jenis_pesanan = isset($item['jenis_pesanan']) ? $item['jenis_pesanan'] : 'ready';

            $queryDetail = "INSERT INTO tbl_detail_transaksi (id_transaksi, id_produk, jumlah, ukuran, warna, bahan, desain, catatan, jenis_pesanan) 
                            VALUES ('$id_transaksi', '$id_produk', '$jumlah', $ukuran, $warna, $bahan, $desain, $catatan, '$jenis_pesanan')";
            
            mysqli_query($koneksi, $queryDetail);
        }

        // Kosongkan keranjang belanja setelah sukses belanja
        unset($_SESSION['keranjang']);

        echo "
        <script>
        Swal.fire({
            title: 'Pesanan Berhasil!',
            text: 'Terima kasih telah berbelanja',
            icon: 'success',
            confirmButtonText: 'Lihat Pesanan',
            confirmButtonColor: '#2ecc71'
        }).then(() => {
            window.location.href = 'pesanan.php';
        });
        </script>
        ";
    } else {
        // Ambil pesan error SQL jika query gagal dijalankan
        $error = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo "
        <script>
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan database: $error',
            icon: 'error',
            confirmButtonColor: '#e74c3c'
        });
        </script>
        ";
    }
}

echo '
</body>
</html>
';
?>