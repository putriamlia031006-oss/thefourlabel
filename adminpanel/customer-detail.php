<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi,
    "SELECT * FROM pelanggan WHERE id_pelanggan='$id'"
);

$data = mysqli_fetch_array($query);

// Proteksi jika ID tidak ditemukan
if(mysqli_num_rows($query) == 0){
    header('location: customer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Customer | Fashion Gassspol</title>

    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        body{
            background:#f4f7fe;
        }

        .custom-card{
            background:white;
            border-radius:20px;
            padding:40px;
            box-shadow:0 10px 30px rgba(0,0,0,0.05);
            margin-top:30px;
        }

        .page-title{
            font-weight:bold;
            margin-bottom:25px;
            text-align:center;
        }

        .form-control{
            border-radius:12px;
            padding:12px;
        }

        .btn-custom{
            border-radius:12px;
            padding:10px 25px;
            font-weight:600;
        }

    </style>

</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="customer.php" class="text-decoration-none">
                    Customer
                </a>
            </li>

            <li class="breadcrumb-item active">
                Detail Customer
            </li>

        </ol>

    </nav>

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="custom-card">

                <h2 class="page-title">
                    <i class="fas fa-user"></i>
                    Edit Customer
                </h2>

                <form method="post">

                    <div class="mb-3">
                        <label>Nama Customer</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?= $data['nama_pelanggan']; ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= $data['email_pelanggan']; ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>

                        <input
                            type="text"
                            name="telepon"
                            class="form-control"
                            value="<?= $data['telepon_pelanggan']; ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="4"
                        ><?= $data['alamat_pelanggan']; ?></textarea>
                    </div>

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            name="editbtn"
                            class="btn btn-primary btn-custom"
                        >
                            <i class="fas fa-save"></i>
                            Update
                        </button>

                        <button
                            type="button"
                            class="btn btn-danger btn-custom"
                            onclick="confirmDelete()"
                        >
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>

                        <input
                            type="submit"
                            name="deletebtn"
                            id="realDeleteBtn"
                            hidden
                        >

                    </div>

                </form>

                <?php

                // =========================
                // UPDATE CUSTOMER
                // =========================

                if(isset($_POST['editbtn'])){

                    $nama       = htmlspecialchars($_POST['nama']);
                    $email      = htmlspecialchars($_POST['email']);
                    $telepon    = htmlspecialchars($_POST['telepon']);
                    $alamat     = htmlspecialchars($_POST['alamat']);

                    $update = mysqli_query($koneksi,

                        "UPDATE pelanggan SET

                            nama_pelanggan='$nama',
                            email_pelanggan='$email',
                            telepon_pelanggan='$telepon',
                            alamat_pelanggan='$alamat'

                        WHERE id_pelanggan='$id'"

                    );

                    if($update){

                        echo "

                        <script>

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data customer berhasil diupdate',
                            icon: 'success'
                        }).then(() => {
                            window.location.href='customer.php';
                        });

                        </script>

                        ";

                    } else {

                        echo "

                        <script>

                        Swal.fire(
                            'Error',
                            '".mysqli_error($koneksi)."',
                            'error'
                        );

                        </script>

                        ";

                    }

                }

                // =========================
                // DELETE CUSTOMER
                // =========================

                if(isset($_POST['deletebtn'])){

                    $delete = mysqli_query($koneksi,

                        "DELETE FROM pelanggan
                         WHERE id_pelanggan='$id'"

                    );

                    if($delete){

                        echo "

                        <script>

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Customer berhasil dihapus',
                            icon: 'success'
                        }).then(() => {
                            window.location.href='customer.php';
                        });

                        </script>

                        ";

                    } else {

                        echo "

                        <script>

                        Swal.fire(
                            'Error',
                            '".mysqli_error($koneksi)."',
                            'error'
                        );

                        </script>

                        ";

                    }

                }

                ?>

            </div>

        </div>

    </div>

</div>

<script>

function confirmDelete(){

    Swal.fire({

        title: 'Yakin ingin menghapus?',
        text: 'Data customer akan dihapus permanen',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',
        cancelButtonColor: '#3674B5',

        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            document.getElementById('realDeleteBtn').click();

        }

    });

}

</script>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>