<?php
session_start();
require "koneksi.php";

// Contoh session pelanggan
// $_SESSION['pelanggan'] = $data;
$pelanggan = $_SESSION['pelanggan'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            background: #f6f0ff;
            font-family: 'Poppins', sans-serif;
        }

        .profile-container{
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .sidebar{
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .profile-img{
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #d6b3ff;
        }

        .username{
            font-size: 20px;
            font-weight: 700;
            margin-top: 15px;
            color: #5b3d87;
        }

        .menu-profile a{
            display: block;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 12px;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu-profile a:hover,
        .menu-profile .active{
            background: linear-gradient(135deg,#d9b8ff,#b784f7);
            color: white;
        }

        .content-profile{
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .content-profile h3{
            color: #6f42c1;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-control{
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .form-control:focus{
            border-color: #b784f7;
            box-shadow: 0 0 0 0.2rem rgba(183,132,247,0.2);
        }

        .btn-save{
            background: linear-gradient(135deg,#d9b8ff,#b784f7);
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
        }

        .btn-save:hover{
            opacity: 0.9;
        }

        .logout-btn{
            background: #ff4d6d;
            color: white !important;
        }

        .logout-btn:hover{
            background: #e6395c !important;
        }
    </style>
</head>
<body>

<div class="container profile-container">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="sidebar text-center">

                <img src="image/profile-default.png" class="profile-img">

                <div class="username">
                    <?php echo $pelanggan['nama_pelanggan']; ?>
                </div>

                <small class="text-muted">
                    Member Fashion Store
                </small>

                <hr>

                <div class="menu-profile text-start">
                    <a href="#" class="active">
                        <i class="fas fa-user me-2"></i> Profil Saya
                    </a>

                    <a href="pesanan.php">
                        <i class="fas fa-box me-2"></i> Pesanan Saya
                    </a>

                    <a href="wishlist.php">
                        <i class="fas fa-heart me-2"></i> Wishlist
                    </a>

                    <a href="alamat.php">
                        <i class="fas fa-map-marker-alt me-2"></i> Alamat
                    </a>

                    <a href="#" onclick="confirmLogout()" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="content-profile">

                <h3>Profil Saya</h3>

                <form action="" method="post">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?php echo $pelanggan['nama_pelanggan']; ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email"
                                   class="form-control"
                                   value="<?php echo $pelanggan['email_pelanggan']; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Nomor HP
                            </label>

                            <input type="text"
                                   class="form-control"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>

                            <input type="date"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Alamat
                        </label>

                        <textarea class="form-control" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Logout?',
        text: 'Anda yakin ingin logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6f42c1',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';
        }
    })
}
</script>

</body>
</html>
