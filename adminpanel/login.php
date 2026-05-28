<?php   
    session_start();
    require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | THE FOUR LABEL</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
    * {
        box-sizing: border-box;
    }

    html, body {
        min-height: 100%;
        margin: 0;
        padding: 0 !important;
        overflow-x: hidden !important;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 45%, #c4b5fd 100%) no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    body::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        background: #7c3aed;
        filter: blur(90px);
        border-radius: 50%;
        top: 15%;
        left: 12%;
        z-index: 1;
        opacity: 0.25;
    }

    body::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        background: #c084fc;
        filter: blur(95px);
        border-radius: 50%;
        bottom: 10%;
        right: 12%;
        z-index: 1;
        opacity: 0.28;
    }

    .login-wrapper {
        position: relative;
        width: 100%;
        max-width: 430px;
        margin: 0 auto;
        padding: 35px 18px;
        z-index: 10;
    }

    .brand-logo {
        text-align: center;
        margin-bottom: 22px;
        color: white;
        font-size: 32px; 
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px; 
        line-height: 1.2;
        text-shadow: 0 3px 8px rgba(76, 29, 149, 0.25);
    }

    .brand-logo span {
        display: block;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 5px;
        margin-top: 6px;
        opacity: 0.9;
    }

    .brand-logo::after {
        content: '';
        display: block;
        width: 58px;
        height: 4px;
        background: white;
        margin: 15px auto 0;
        border-radius: 10px;
        opacity: 0.9;
    }

    .login-box {
        background: rgba(221, 203, 255, 0.55);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 34px 32px;
        border-radius: 26px; 
        box-shadow: 0 14px 28px rgba(76, 29, 149, 0.18) !important;
        border: 1px solid rgba(255, 255, 255, 0.35);
    }

    .login-box h2 {
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 18px;
        text-align: center;
        font-size: 21px;
        letter-spacing: 1.5px;
        text-shadow: 0 2px 5px rgba(76, 29, 149, 0.22);
    }

    .login-box .subtitle {
        text-align: center;
        color: rgba(255, 255, 255, 0.95);
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 28px;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .form-label {
        color: #ffffff !important;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .form-control {
        border-radius: 13px;
        padding: 13px 16px;
        border: none;
        margin-bottom: 20px;
        background-color: #eef4ff;
        color: #111827;
        font-weight: 500;
        box-shadow: none;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.22) !important;
        border-color: #7c3aed;
        background-color: #ffffff;
        outline: none !important;
    }

    .btn-login {
        background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        border: none;
        border-radius: 13px;
        padding: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
        transition: all 0.3s ease;
        color: white;
        margin-top: 10px;
        box-shadow: 0 8px 18px rgba(124, 58, 237, 0.24);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(76, 29, 149, 0.26);
        color: white;
    }

    .copyright-text {
        color: white;
        opacity: 0.9;
        margin-top: 22px;
        text-align: center;
        font-size: 12px;
        letter-spacing: 1px;
        text-shadow: 0 2px 5px rgba(76, 29, 149, 0.2);
    }

    body.swal2-shown {
        overflow: hidden !important;
        padding-right: 0 !important;
    }

    .swal2-popup {
        border-radius: 22px !important;
        background: rgba(255, 255, 255, 0.97) !important;
    }
</style>
</head>
<body>

    <div class="login-wrapper">
        <div class="brand-logo">
            THE FOUR LABEL
            <span>KONVEKSI & FASHION PRODUCTION</span>
        </div>
        
        <div class="login-box">
            <h2>ADMIN PANEL</h2>
            <p class="subtitle">Kelola produksi, pesanan, dan data konveksi</p>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label small fw-bold">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
                </div>
                <button class="btn btn-login w-100" type="submit" name="loginbtn">Login</button>
            </form>
        </div>
        <p class="copyright-text">© 2026 THE FOUR LABEL - SI 24 P SIM 2 - Kelompok 2</p>
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
                        text: 'Selamat datang di Admin Panel The Four Label, $username',
                        confirmButtonColor: '#a855f7'
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