<?php
// Halaman pengelolaan peminjaman buku perpustakaan
require "../../data/config.php";
$dataPeminjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, member.kelas, member.jurusan, peminjaman.id_admin,  peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian 
FROM peminjaman 
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../styles/admin/pinjam-buku.css">
    <title>Kelola Peminjaman Buku || Admin</title>
  </head>
  
  <body>
    <nav class="navbar">
      <div class="navbar-container">
        <a href="#">
          <img src="../../images/logoNav.png" alt="logo" class="logo">
        </a>
        <a class="dashboard-btn" href="../dashboard.php">Dashboard</a>
      </div>
    </nav>

    <main class="main-content">
      <section class="table-section">
        <h2>List Peminjaman</h2>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Id Peminjaman</th>
                <th>Id Buku</th>
                <th>Judul Buku</th>
                <th>NISN Siswa</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Id Admin</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataPeminjam as $item) : ?>
                <tr>
                  <td><?= $item["id_peminjaman"] ?></td>
                  <td><?= $item["id_buku"] ?></td>
                  <td><?= $item["judul"] ?></td>
                  <td><?= $item["nisn"] ?></td>
                  <td><?= $item["nama"] ?></td>
                  <td><?= $item["kelas"] ?></td>
                  <td><?= $item["jurusan"] ?></td>
                  <td><?= $item["id_admin"] ?></td>
                  <td><?= $item["tgl_peminjaman"] ?></td>
                  <td><?= $item["tgl_pengembalian"] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-container">
        <p>Created by <span class="author">Perpustakaan MTs MMH</span> &copy; 2024</p>
        <p>Version 1.0</p>
      </div>
    </footer>
  </body>
</html>