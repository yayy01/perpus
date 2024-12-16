<?php 
session_start();

if (!isset($_SESSION["signIn"])) {
  header("Location: ../../login/member/sign_in.php");
  exit;
}

require "../../data/config.php";
$akunMember = $_SESSION["member"]["nisn"];
$data = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian
FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN admin ON peminjaman.id_admin = admin.id
WHERE peminjaman.nisn = $akunMember");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi peminjaman Buku || Member</title>
  <link rel="stylesheet" href="../../styles/member/trans-kembali.css">
</head>
<body>

  <nav class="navbar">
    <div class="container">
      <img src="../../images/logoNav.png" alt="logo">
      <a href="../dashboard.php">Dashboard</a>
    </div>
  </nav>

  <div class="container">
    <div class="alert">
      Riwayat transaksi Peminjaman Buku Anda - <span class="fw-bold text-capitalize"><?= htmlentities($_SESSION["member"]["nama"]); ?></span>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Id Peminjaman</th>
            <th>Id Buku</th>
            <th>Judul Buku</th>
            <th>Nisn</th>
            <th>Nama</th>
            <th>Nama Admin</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $item) : ?>
            <tr>
              <td><?= $item["id_peminjaman"]; ?></td>
              <td><?= $item["id_buku"]; ?></td>
              <td><?= $item["judul"]; ?></td>
              <td><?= $item["nisn"]; ?></td>
              <td><?= $item["nama"]; ?></td>
              <td><?= $item["nama_admin"]; ?></td>
              <td><?= $item["tgl_peminjaman"]; ?></td>
              <td><?= $item["tgl_pengembalian"]; ?></td>
              <td>
                <a class="btn" href="pengembalianBuku.php?id=<?= $item["id_peminjaman"]; ?>">Kembalikan</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    <p>Created by <span class="text-primary">Perpustakaan MTs MMH</span> © 2024</p>
    <p>Versi 1.0</p>
  </footer>

</body>
</html>
