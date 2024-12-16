<?php 
// Halaman pengelolaan pengembalian Buku Perpustakaan
require "../../data/config.php";
$dataPeminjam = queryReadData("SELECT pengembalian.id_pengembalian, pengembalian.id_buku, buku.judul, buku.kategori, pengembalian.nisn, member.nama, member.kelas, member.jurusan, admin.nama_admin, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id_buku
INNER JOIN member ON pengembalian.nisn = member.nisn
INNER JOIN admin ON pengembalian.id_admin = admin.id")
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../styles/admin/kembali-buku.css">
    <title>Kelola Pengembalian Buku || Admin</title>
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
              <th>Id Pengembalian</th>
              <th>Id Buku</th>
              <th>Judul Buku</th>
              <th>Kategori</th>
              <th>NISN</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Jurusan</th>
              <th>Nama Admin</th>
              <th>Tanggal Pengembalian</th>
              <th>Keterlambatan</th>
              <th>Denda</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dataPeminjam as $item) : ?>
              <tr>
                <td><?= $item["id_pengembalian"] ?></td>
                <td><?= $item["id_buku"] ?></td>
                <td><?= $item["judul"] ?></td>
                <td><?= $item["kategori"] ?></td>
                <td><?= $item["nisn"] ?></td>
                <td><?= $item["nama"] ?></td>
                <td><?= $item["kelas"] ?></td>
                <td><?= $item["jurusan"] ?></td>
                <td><?= $item["nama_admin"] ?></td>
                <td><?= $item["buku_kembali"] ?></td>
                <td><?= $item["keterlambatan"] ?></td>
                <td><?= $item["denda"] ?></td>
                <td>
                  <a href="deletePengembalian.php?id=<?= $item["id_pengembalian"] ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data?');">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>

    <footer class="footer">
      <p>Created by <span class="author">Muya</span> &copy; 2024</p>
      <p>Versi 1.0</p>
    </footer>
  </body>
</html>