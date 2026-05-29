<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION["pelanggan"])) {
    echo "
    <script>
        alert('Silakan login terlebih dahulu');
        location='login.php';
    </script>
    ";
    exit;
}

if (empty($_SESSION['keranjang'])) {
    echo "
    <script>
        alert('Keranjang belanja Anda kosong');
        location='produk.php';
    </script>
    ";
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$jenis_transaksi = "ready stock";
$status_pembayaran = "belum bayar";
$status_transaksi  = "pending";

$total_harga = $_POST['total_final'];

$total_produk = 0;

foreach ($_SESSION['keranjang'] as $item) {
    $total_produk += $item['jumlah'];
}

$queryTransaksi = mysqli_query($koneksi, "
    INSERT INTO tbl_transaksi
    (
        id_pelanggan,
        jenis_transaksi,
        status_pembayaran,
        status_transaksi,
        tanggal_transaksi,
        total_harga,
        total_produk
    )
    VALUES
    (
        '$id_pelanggan',
        '$jenis_transaksi',
        '$status_pembayaran',
        '$status_transaksi',
        NOW(),
        '$total_harga',
        '$total_produk'
    )
");

if (!$queryTransaksi) {
    echo "
    <script>
        alert('Gagal menyimpan transaksi: " . mysqli_error($koneksi) . "');
        history.back();
    </script>
    ";
    exit;
}

$id_transaksi = mysqli_insert_id($koneksi);

/*
    Simpan detail transaksi.
    Karena di checkout.php keranjang dibaca sebagai:
    foreach ($_SESSION['keranjang'] as $key => $item)
    maka $key dipakai sebagai id_produk.
*/
foreach ($_SESSION['keranjang'] as $id_produk => $item) {

    $jumlah = $item['jumlah'];

    $queryDetail = mysqli_query($koneksi, "
        INSERT INTO tbl_detail_transaksi
        (
            id_transaksi,
            id_produk,
            jumlah
        )
        VALUES
        (
            '$id_transaksi',
            '$id_produk',
            '$jumlah'
        )
    ");

    if (!$queryDetail) {
        echo "
        <script>
            alert('Gagal menyimpan detail transaksi: " . mysqli_error($koneksi) . "');
            history.back();
        </script>
        ";
        exit;
    }
}

// Kosongkan keranjang setelah checkout berhasil
unset($_SESSION['keranjang']);

echo "
<script>
    alert('Checkout berhasil');
    location='upload-pembayaran.php?id=$id_transaksi';
</script>
";
?>