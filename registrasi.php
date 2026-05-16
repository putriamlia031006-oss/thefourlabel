<?php   
    session_start();
    require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | THE FOUR LABEL</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        * { box-sizing: border-box; }
        * { box-sizing: border-box; }

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ede9fe, #f5f3ff);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 10px 30px rgba(167, 139, 250, 0.2);
}

.register-box h2 {
    text-align: center;
    font-weight: 700;
    color: #7c3aed;
    margin-bottom: 20px;
}

.brand-title {
    text-align: center;
    font-weight: 800;
    color: #7c3aed;
    margin-bottom: 10px;
}

.form-label {
    font-size: 13px;
    color: #6b7280;
}

.form-control {
    border-radius: 10px;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.2);
}

.btn-register {
    background: linear-gradient(135deg, #a78bfa, #7c3aed);
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-weight: 600;
    color: white;
    margin-top: 10px;
    transition: 0.3s;
}

.btn-register:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
}

.login-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.login-link a {
    color: #7c3aed;
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}

        .btn-register:hover { background-color: #4da3ff; transform: translateY(-2px); }
        .login-link { text-align: center; margin-top: 20px; color: white; font-size: 14px; }
        .login-link a { color: #4da3ff; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="register-box">
        <div class="text-center mb-3">
            <h4 class="brand-title">THE FOUR LABEL</h4>
        </div>
        <h2>JOIN US</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap Anda">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" name="email" placeholder="email@contoh.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" name="password" minlength="6" placeholder="Minimal 6 karakter">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Telepon/WA</label>
                <input type="text" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat Lengkap</label>
                <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap pengiriman" required></textarea>
            </div>
            
            <button class="btn btn-register w-100" type="submit" name="daftar">Daftar Akun</button>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (isset($_POST['daftar'])) {
        $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $email   = mysqli_real_escape_string($koneksi, $_POST['email']);
        $pass    = mysqli_real_escape_string($koneksi, $_POST['password']);
        $telp    = mysqli_real_escape_string($koneksi, $_POST['telepon']);
        $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);

        // 1. Cek apakah email sudah digunakan
        $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
        $yang_cocok = $ambil->num_rows;

        if ($yang_cocok == 1) {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Pendaftaran Gagal',
                    text: 'Email sudah terdaftar, gunakan email lain!'
                });
            </script>";
        } else {
            // 2. Masukkan ke database
            $koneksi->query("INSERT INTO pelanggan (email_pelanggan, password_pelanggan, nama_pelanggan, telepon_pelanggan, alamat_pelanggan) 
                             VALUES ('$email', '$pass', '$nama', '$telp', '$alamat')");

            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Akun Anda telah terdaftar, silahkan login.',
                }).then(function() {
                    window.location.href = 'login.php';
                });
            </script>";
        }
    }
    ?>
</body>
</html>