<?php
require "../../data/config.php";
$buku = queryReadData("SELECT * FROM buku");

// Mengaktifkan tombol search engine
if (isset($_POST["search"])) {
  // Ambil apa saja yang diketikkan user di dalam input dan kirimkan ke function search
  $buku = search($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../styles/admin/daftar-buku.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Kelola Buku || Admin</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">
                <img src="../../images/logoNav.png" alt="logo" width="120px">
            </a>
            <div class="navbar-links">
                <a href="../dashboard.php" class="nav-link">Dashboard</a>
                <a href="tambahBuku.php" class="nav-link">Tambah Buku</a>
            </div>
        </div>
    </nav>

    <!-- Form Pencarian (posisi fixed di pojok kanan) -->
    <form action="" method="post" class="search-form">
        <input class="search-input" type="text" name="keyword" id="keyword" placeholder="Cari data buku...">
        <button class="search-button" type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <div class="content">
        <!-- Card Buku -->
        <div class="card-container">
            <?php foreach ($buku as $item) : ?>
                <div class="card">
                    <img src="../../imgDB/<?= $item["cover"]; ?>" alt="coverBuku" class="card-img">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item["judul"]; ?></h5>
                        <hr>
                        <ul>
                            <li>Kategori: <?= $item["kategori"]; ?></li>
                            <li>ID Buku: <?= $item["id_buku"]; ?></li>
                        </ul>
                        <hr>
                        <div class="card-actions">
                            <a href="updateBuku.php?idReview=<?= $item["id_buku"]; ?>" class="btn btn-edit">Edit</a>
                            <a href="deleteBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data buku?');">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="footer">
      <div class="footer-container">
        <p class="author">Created by Perpustakaan MTs MMH © 2024</p>
        <p>versi 1.0</p>
      </div>
    </footer>
</body>
</html>
