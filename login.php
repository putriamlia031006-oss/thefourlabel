<?php 
session_start();
require "koneksi.php";

// Jika sudah login
if(isset($_SESSION['pelanggan'])){
    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan | THE FOUR LABEL</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>

        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#f3e8ff 0%,#d8b4fe 40%,#c084fc 100%);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-wrapper{
            width:100%;
            max-width:450px;
            padding:20px;
        }

        .brand-logo{
            text-align:center;
            margin-bottom:30px;
            color:white;
            font-size:38px;
            font-weight:800;
            letter-spacing:6px;
        }

        .brand-logo span{
            display:block;
            font-size:14px;
            font-weight:300;
            letter-spacing:8px;
        }

        .login-box{
            background:rgba(255,255,255,0.2);
            backdrop-filter:blur(18px);
            padding:40px;
            border-radius:28px;
            box-shadow:0 20px 45px rgba(0,0,0,0.15);
        }

        .login-box h2{
            text-align:center;
            font-weight:700;
            margin-bottom:30px;
            color:#5b3d78;
        }

        .form-control{
            border-radius:14px;
            padding:12px;
        }

        .btn-login{
            background:linear-gradient(135deg,#C68EFD,#9333ea);
            border:none;
            border-radius:14px;
            padding:14px;
            color:white;
            font-weight:bold;
        }

        .register-link{
            text-align:center;
            margin-top:20px;
        }

    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="brand-logo">
        THE
        <span>FOUR LABEL</span>
    </div>

    <div class="login-box">

        <h2>CUSTOMER LOGIN</h2>

        <form method="post">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <button type="submit"
                    name="login_pelanggan"
                    class="btn btn-login w-100">

                Sign In

            </button>

        </form>

        <div class="register-link">
            Belum punya akun?
            <a href="registrasi.php">Daftar Sekarang</a>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

if(isset($_POST['login_pelanggan'])){

    $email = mysqli_real_escape_string($koneksi,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi,"
        SELECT * FROM pelanggan
        WHERE email_pelanggan='$email'
    ");

    $countdata = mysqli_num_rows($query);

    if($countdata > 0){

        $data = mysqli_fetch_assoc($query);

        if($password === $data['password_pelanggan']){

            // SESSION LOGIN
            $_SESSION['pelanggan'] = [
                'id_pelanggan' => $data['id_pelanggan'],
                'nama_pelanggan' => $data['nama_pelanggan'],
                'email_pelanggan' => $data['email_pelanggan'],
                'telepon_pelanggan' => $data['telepon_pelanggan']
            ];

            echo "
            <script>
                Swal.fire({
                    icon:'success',
                    title:'Login Berhasil!',
                    text:'Selamat Datang ".$data['nama_pelanggan']."',
                    showConfirmButton:false,
                    timer:2000
                }).then(() => {
                    window.location='index.php';
                });
            </script>
            ";

        }else{

            echo "
            <script>
                Swal.fire({
                    icon:'error',
                    title:'Password Salah'
                });
            </script>
            ";

        }

    }else{

        echo "
        <script>
            Swal.fire({
                icon:'warning',
                title:'Email Tidak Ditemukan'
            });
        </script>
        ";

    }

}
?>

</body>
</html>