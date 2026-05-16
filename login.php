<?php 
    session_start();
    require "koneksi.php";

    // Proteksi halaman: Jika sudah login, lempar ke index
    if(isset($_SESSION['pelanggan'])){
        header("location:index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan | THE FOUR LABEL</title>
    
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0 !important;
            overflow: hidden !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3e8ff 0%, #d8b4fe 40%, #c084fc 100%);
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            z-index: 10;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 30px;
            color: white;
            font-size: 38px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 6px;
            line-height: 1.2;
            text-shadow: 0 4px 15px rgba(126, 96, 191, 0.5);
        }

        .brand-logo span {
            display: block;
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 8px;
            margin-top: -5px;
            opacity: 0.95;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            padding: 40px;
            border-radius: 28px;
            box-shadow: 0 20px 45px rgba(126, 96, 191, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        .login-box h2 {
            font-weight: 700;
            color: #5b3d78;
            margin-bottom: 30px;
            text-align: center;
            font-size: 22px;
        }

        .form-label {
            color: #6b4f85 !important;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 16px;
            border: 1px solid #e9d5ff;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.85);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #C68EFD;
            box-shadow: 0 0 0 0.25rem rgba(198, 142, 253, 0.25);
            background-color: white;
        }

        .btn-login {
            background: linear-gradient(135deg, #C68EFD, #a55eea);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s ease;
            color: white;
            box-shadow: 0 10px 20px rgba(198, 142, 253, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #b56df8, #9333ea);
            box-shadow: 0 15px 30px rgba(198, 142, 253, 0.4);
            color: white;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            color: #6b4f85;
            font-size: 14px;
        }

        .register-link a {
            color: #9333ea;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .register-link a:hover {
            color: #7e22ce;
            text-decoration: underline;
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
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" 
                           placeholder="nama@email.com" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" 
                           placeholder="********" required>
                </div>
                <button class="btn btn-login w-100" type="submit" name="login_pelanggan">
                    Sign In
                </button>
            </form>
            
            <div class="register-link">
                Belum punya akun? <a href="registrasi.php">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if(isset($_POST['login_pelanggan'])){
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $password = $_POST['password'];

        $query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
        $countdata = mysqli_num_rows($query);
        
        if($countdata > 0){
            $data = mysqli_fetch_array($query);
            
            // Perhatian: Disarankan menggunakan password_verify($password, $data['password_pelanggan']) 
            // jika password di database di-hash.
            if ($password === $data['password_pelanggan']){
                $_SESSION['pelanggan'] = $data;
                
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Selamat Berbelanja, " . $data['nama_pelanggan'] . "',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href='index.php';
                    });
                </script>";
            } else {
                echo "<script>Swal.fire({icon: 'error', title: 'Gagal', text: 'Password salah!'});</script>";
            }
        } else {
            echo "<script>Swal.fire({icon: 'warning', title: 'Opps!', text: 'Email belum terdaftar!'});</script>";
        }
    }
    ?>
</body>
</html>