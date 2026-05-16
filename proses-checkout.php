<?php

session_start();

require "koneksi.php";

echo '

<!DOCTYPE html>
<html>
<head>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        body{
            font-family:Arial,sans-serif;
            background:#f4f4f4;
        }

    </style>

</head>
<body>

';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // =========================
    // AMBIL DATA FORM
    // =========================

    $nama_pembeli = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );

    $nomor_hp = mysqli_real_escape_string(
        $koneksi,
        $_POST['telepon']
    );

    $email_input = mysqli_real_escape_string(
        $koneksi,
        $_POST['email']
    );

    $alamat = mysqli_real_escape_string(
        $koneksi,
        $_POST['alamat']
    );

    $total_final = mysqli_real_escape_string(
        $koneksi,
        $_POST['total_final']
    );

    $tanggal_transaksi = date("Y-m-d");

    $status_transaksi = "Pending";

    // =========================
    // VALIDASI KERANJANG
    // =========================

    if(
        !isset($_SESSION['keranjang']) ||
        empty($_SESSION['keranjang'])
    ){

        echo "

        <script>

        Swal.fire({
            icon:'error',
            title:'Keranjang Kosong',
            text:'Silakan pilih produk terlebih dahulu'
        }).then(() => {

            window.location='produk.php';

        });

        </script>

        ";

        exit;

    }

    // =========================
    // CEK CUSTOMER
    // =========================

    $cekCustomer = mysqli_query(

        $koneksi,

        "SELECT id_pelanggan
         FROM pelanggan
         WHERE email_pelanggan='$email_input'"

    );

    // =========================
    // JIKA SUDAH ADA
    // =========================

    if(mysqli_num_rows($cekCustomer) > 0){

        $customerData = mysqli_fetch_assoc($cekCustomer);

        $id_pelanggan = $customerData['id_pelanggan'];

        mysqli_query(

            $koneksi,

            "UPDATE pelanggan SET

                nama_pelanggan='$nama_pembeli',
                telepon_pelanggan='$nomor_hp',
                alamat_pelanggan='$alamat'

            WHERE id_pelanggan='$id_pelanggan'"

        );

    }

    // =========================
    // JIKA BELUM ADA
    // =========================

    else{

        mysqli_query(

            $koneksi,

            "INSERT INTO pelanggan

            (
                nama_pelanggan,
                email_pelanggan,
                telepon_pelanggan,
                alamat_pelanggan
            )

            VALUES

            (
                '$nama_pembeli',
                '$email_input',
                '$nomor_hp',
                '$alamat'
            )"

        );

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
    // INSERT TRANSAKSI
    // =========================

    $queryTransaksi = "

        INSERT INTO tbl_transaksi

        (
            id_pelanggan,
            tanggal_transaksi,
            status_transaksi,
            total_produk,
            total_harga
        )

        VALUES

        (
            '$id_pelanggan',
            '$tanggal_transaksi',
            '$status_transaksi',
            '$total_qty',
            '$total_final'
        )

    ";

    if(mysqli_query($koneksi, $queryTransaksi)){

        $id_transaksi = mysqli_insert_id($koneksi);

        $_SESSION['last_id'] = $id_transaksi;

        // =========================
        // INSERT DETAIL TRANSAKSI
        // =========================

        foreach($_SESSION['keranjang'] as $item){

            $id_produk = $item['id'];

            $jumlah = $item['jumlah'];

            // =========================
            // OPTIONAL FIELD
            // =========================

            $ukuran = !empty($item['ukuran'])
                ? "'".mysqli_real_escape_string(
                    $koneksi,
                    $item['ukuran']
                  )."'"
                : "NULL";

            $warna = !empty($item['warna'])
                ? "'".mysqli_real_escape_string(
                    $koneksi,
                    $item['warna']
                  )."'"
                : "NULL";

            $bahan = !empty($item['bahan'])
                ? "'".mysqli_real_escape_string(
                    $koneksi,
                    $item['bahan']
                  )."'"
                : "NULL";

            $desain = !empty($item['desain'])
                ? "'".mysqli_real_escape_string(
                    $koneksi,
                    $item['desain']
                  )."'"
                : "NULL";

            $catatan = !empty($item['catatan'])
                ? "'".mysqli_real_escape_string(
                    $koneksi,
                    $item['catatan']
                  )."'"
                : "NULL";

            // =========================
            // JENIS PESANAN
            // =========================

            $jenis_pesanan = isset($item['jenis_pesanan'])
                ? $item['jenis_pesanan']
                : 'ready';

            // =========================
            // INSERT DETAIL
            // =========================

            $queryDetail = "

                INSERT INTO tbl_detail_transaksi

                (
                    id_transaksi,
                    id_produk,
                    jumlah,
                    ukuran,
                    warna,
                    bahan,
                    desain,
                    catatan,
                    jenis_pesanan
                )

                VALUES

                (
                    '$id_transaksi',
                    '$id_produk',
                    '$jumlah',
                    $ukuran,
                    $warna,
                    $bahan,
                    $desain,
                    $catatan,
                    '$jenis_pesanan'
                )

            ";

            mysqli_query($koneksi, $queryDetail);

        }

        // =========================
        // HAPUS SESSION KERANJANG
        // =========================

        unset($_SESSION['keranjang']);

        echo "

        <script>

        Swal.fire({

            title:'Pesanan Berhasil!',
            text:'Terima kasih telah berbelanja',
            icon:'success',
            confirmButtonText:'Lihat Pesanan'

        }).then(() => {

            window.location.href='pesanan.php';

        });

        </script>

        ";

    }

    // =========================
    // ERROR TRANSAKSI
    // =========================

    else{

        $error = mysqli_error($koneksi);

        echo "

        <script>

        Swal.fire(
            'Gagal!',
            '$error',
            'error'
        );

        </script>

        ";

    }

}

echo '

</body>
</html>

';

?>