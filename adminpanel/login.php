<?php   
    session_start();
    require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Fashion Gassspol</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
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
            /* Latar belakang diubah menjadi lebih gelap (Deep Navy Gradient) */
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) no-repeat center center fixed;
            background-size: cover;
        }

        /* Dekorasi cahaya di belakang untuk memperkuat efek blur (Opsional namun estetik) */
        body::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: #3674B5;
            filter: blur(150px);
            border-radius: 50%;
            top: 20%;
            left: 20%;
            z-index: 1;
            opacity: 0.4;
        }

        .login-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 450px;
            padding: 20px;
            z-index: 10;
        }

        /* --- STYLING JUDUL AESTHETIC MODERN --- */
        .brand-logo {
            text-align: center;
            margin-bottom: 30px;
            color: white;
            font-size: 38px; 
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 6px; 
            line-height: 1.2;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .brand-logo span {
            display: block;
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 8px;
            margin-top: -5px;
            opacity: 0.9;
        }

        .brand-logo::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: white;
            margin: 15px auto 0;
            border-radius: 2px;
            opacity: 0.8;
        }

        .login-box {
            /* Container dibuat menjadi BLUR (Glassmorphism) */
            background: rgba(255, 255, 255, 0.1); /* Transparansi rendah */
            backdrop-filter: blur(20px); /* Efek blur utama */
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px; 
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.2); /* Garis tepi tipis agar efek kaca terlihat */
        }

        .login-box h2 {
            font-weight: 600;
            color: #ffffff; /* Warna judul diubah putih agar kontras dengan blur gelap */
            margin-bottom: 30px;
            text-align: center;
            font-size: 20px;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Penyesuaian label agar terbaca di atas background blur */
        .form-label {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Sedikit transparansi pada input */
            color: #1e293b;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(54, 116, 181, 0.4) !important;
            border-color: #3674B5;
            background-color: #fff;
            outline: none !important;
        }

        .btn-login {
            background-color: #3674B5;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s ease;
            color: white;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #4da3ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(54, 116, 181, 0.4);
        }

        .copyright-text {
            color: white;
            opacity: 0.6;
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            letter-spacing: 1px;
        }

        body.swal2-shown {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        /* Menyesuaikan SweetAlert agar sesuai tema gelap */
        .swal2-popup {
            border-radius: 20px !important;
            background: rgba(255, 255, 255, 0.95) !important;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="brand-logo">
            FASHION
            <span>GASSSPOL</span>
        </div>
        
        <div class="login-box">
            <h2>ADMIN PANEL</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label small fw-bold">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
                </div>
                <button class="btn btn-login w-100" type="submit" name="loginbtn">Sign In</button>
            </form>
        </div>
        <p class="copyright-text">© 2025 FASHION GASSSPOL - SI 24 P SIM 2</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if(isset($_POST['loginbtn'])){
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);

        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
        $countdata = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);
        
        if($countdata > 0){
            if ($password === trim($data['password'])){
                $_SESSION['username'] = $data['username'];
                $_SESSION['login'] = true;
                
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Selamat datang kembali, $username',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    }).then(function() {
                        window.location.href = '../adminpanel';
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Salah',
                        text: 'Silakan periksa kembali password Anda!',
                        confirmButtonColor: '#3674B5'
                    });
                </script>";
            }
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Akun Tidak Ditemukan',
                    text: 'Username belum terdaftar!',
                    confirmButtonColor: '#3674B5'
                });
            </script>";
        }
    }
    ?>
</body>
</html>