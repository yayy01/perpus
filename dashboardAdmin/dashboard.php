<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: ../login/admin/sign_in.php");
    exit;
}

// Pastikan data admin tersedia dalam session
if (!isset($_SESSION['admin_username'])) {
    echo "Data admin tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/dash-min.css"> <!-- Link ke file CSS Anda -->
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>
</head>
<body>

<nav class="navbar fixed-top bg-body-tertiary shadow-sm">
    <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
            <img src="../images/logoNav.png" alt="logo" width="120px">
        </a>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../images/adminLogo.png" alt="adminLogo" width="40px">
            </button>
            <ul class="dropdown-menu position-absolute mt-2 p-2">
                <li class="text-center">
                    <a class="dropdown-item" href="#">
                        <img src="../images/adminLogo.png" alt="adminLogo" width="30px">
                    </a>
                </li>
                <li class="text-center text-secondary">
                    <span class="text-capitalize"><?php echo $_SESSION['admin_username']; ?></span>
                </li>
                <hr>
                <li class="text-center mb-2">
                    <a class="dropdown-item" href="#">Akun Terverifikasi <span class="text-primary"><i class="fa-solid fa-circle-check"></i></span></a>
                </li>
                <li class="text-center">
                    <a class="dropdown-item p-2 bg-danger text-light rounded" href="signOut.php">Sign Out <i class="fa-solid fa-right-to-bracket"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="mt-5 p-4">
    <?php
    // Mendapatkan tanggal dan waktu saat ini
    $day = date('l');
    $dayOfMonth = date('d');
    $month = date('F');
    $year = date('Y');
    ?>

    <h1 class="mt-5 fw-bold">Dashboard - <span class="fs-4 text-secondary"><?php echo "$day $dayOfMonth $month $year"; ?></span></h1>

    <div class="alert alert-success" role="alert">
        Selamat datang admin - <span class="fw-bold text-capitalize"><?php echo $_SESSION['admin_username']; ?></span> di Dashboard perpustakaan MTs MMH
    </div>

    <div class="mt-4 p-3">
        <div class="d-flex flex-wrap jusFtify-content-center gap-2">
            <div class="cardImg">
                <a href="member/member.php">
                    <img src="../images/dashboardCardMember/member.png" alt="daftar member" style="max-width: 100%;" width="600px">
                </a>
            </div>
            <div class="cardImg">
                <a href="buku/daftarBuku.php">
                    <img src="../images/dashboardCardMember/bukuAdmin.png" alt="daftar buku" style="max-width: 100%;" width="600px">
                </a>
            </div>
            <div class="cardImg">
                <a href="peminjaman/peminjamanBuku.php">
                    <img src="../images/dashboardCardMember/peminjaman.png" alt="peminjaman" style="max-width: 100%;" width="600px">
                </a>
            </div>
            <div class="cardImg">
                <a href="pengembalian/pengembalianBuku.php">
                    <img src="../images/dashboardCardMember/pengembalianAdmin.png" alt="pengembalian" style="max-width: 100%;" width="600px">
                </a>
            </div>
            <div class="cardImg">
                <a href="denda/daftarDenda.php">
                    <img src="../images/dashboardCardMember/denda.png" alt="denda" style="max-width: 100%;" width="600px">
                </a>
            </div>
        <!-- Tambahkan lebih banyak kartu sesuai kebutuhan -->
        </div>
    </div>
</body>
</html>
