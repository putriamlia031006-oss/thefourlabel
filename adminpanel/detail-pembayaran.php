<?php
require "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi,"
SELECT *
FROM tbl_pembayaran
JOIN tbl_transaksi
ON tbl_pembayaran.id_transaksi =
   tbl_transaksi.id_transaksi

WHERE tbl_pembayaran.id_pembayaran='$id'
");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['valid'])){

    mysqli_query($koneksi,"
    UPDATE tbl_pembayaran
    SET status_verifikasi='berhasil'
    WHERE id_pembayaran='$id'
    ");

    mysqli_query($koneksi,"
    UPDATE tbl_transaksi
    SET
        status_pembayaran='sudah bayar',
        status_transaksi='diproses'
    WHERE id_transaksi='".$data['id_transaksi']."'
    ");

}

if(isset($_POST['tolak'])){

    mysqli_query($koneksi,"
    UPDATE tbl_pembayaran
    SET status_verifikasi='ditolak'
    WHERE id_pembayaran='$id'
    ");

    mysqli_query($koneksi,"
    UPDATE tbl_transaksi
    SET status_pembayaran='ditolak'
    WHERE id_transaksi='".$data['id_transaksi']."'
    ");

}
?>