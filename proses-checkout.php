<?php
session_start();
require "koneksi.php";

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$jenis_transaksi = "ready stock";

$total_harga = $_POST['total_final'];

$total_produk = 0;

foreach($_SESSION['keranjang'] as $item){

    $total_produk += $item['jumlah'];

}

$status_pembayaran = "belum bayar";
$status_transaksi  = "pending";

mysqli_query($koneksi,"
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

$id_transaksi = mysqli_insert_id($koneksi);

echo "
<script>
    alert('Checkout berhasil');
    location='upload-pembayaran.php?id=$id_transaksi';
</script>
";
?>