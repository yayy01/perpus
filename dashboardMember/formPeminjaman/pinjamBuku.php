<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../login/member/sign_in.php");
  exit;
}
require "../../data/config.php";
// Tangkap id buku dari URL (GET)
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
//Menampilkan data siswa yg sedang login
$nisnSiswa = $_SESSION["member"]["nisn"];
$dataSiswa = queryReadData("SELECT * FROM member WHERE nisn = $nisnSiswa");
$idAdmin = queryReadData("SELECT * FROM admin");

// Peminjaman 
if(isset($_POST["pinjam"]) ) {
  
  if(pinjamBuku($_POST) > 0) {
    echo "<script>
    alert('Buku berhasil dipinjam');
    </script>";
  }else {
    echo "<script>
    alert('Buku gagal dipinjam!');
    </script>";
  }
  
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Form Pinjam Buku || Member</title>
    <link rel="stylesheet" href="../../styles/member/pinjamBuku.css">
  </head>
  <body>
    <!-- Header -->
    <nav class="navbar">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../../images/logoNav.png" alt="logo" class="logo">
        </a>
        <a class="btn dashboard-btn" href="../dashboard.php">Dashboard</a>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
      <h2>Form Peminjaman Buku</h2>

      <!-- Card Buku -->
      <div class="card">
        <div class="card-header">Data Lengkap Buku</div>
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <?php foreach ($query as $item) : ?>
              <img src="../../imgDB/<?= $item["cover"]; ?>" alt="coverBuku">
              <form action="" method="post">
                <div class="input-group">
                  <span>Id Buku</span>
                  <input type="text" value="<?= $item["id_buku"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Kategori</span>
                  <input type="text" value="<?= $item["kategori"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Judul</span>
                  <input type="text" value="<?= $item["judul"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Pengarang</span>
                  <input type="text" value="<?= $item["pengarang"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Penerbit</span>
                  <input type="text" value="<?= $item["penerbit"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Tahun Terbit</span>
                  <input type="text" value="<?= $item["tahun_terbit"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Jumlah Halaman</span>
                  <input type="text" value="<?= $item["jumlah_halaman"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Deskripsi Buku</span>
                  <input type="text" value="<?= $item["buku_deskripsi"]; ?>" readonly>
                </div>
              </form>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Card Siswa -->
      <div class="card mt-4">
        <div class="card-header">Data Lengkap Siswa</div>
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <img src="../../images/memberLogo.png" alt="memberLogo">
            <form action="" method="post">
              <?php foreach ($dataSiswa as $item) : ?>
                <div class="input-group">
                  <span>NISN</span>
                  <input type="number" value="<?= $item["nisn"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Kode member</span>
                  <input type="string" value="<?= $item["kode_member"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Nama</span>
                  <input type="string" value="<?= $item["nama"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Jenis kelamin</span>
                  <input type="string" value="<?= $item["jenis_kelamin"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Kelas</span>
                  <input type="string" value="<?= $item["kelas"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Jurusan</span>
                  <input type="string" value="<?= $item["jurusan"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>No Tlp</span>
                  <input type="string" value="<?= $item["no_tlp"]; ?>" readonly>
                </div>
                <div class="input-group">
                  <span>Tanggal Daftar</span>
                  <input type="string" value="<?= $item["tgl_pendaftaran"]; ?>" readonly>
                </div>
              <?php endforeach; ?>
            </form>
          </div>
        </div>
      </div>

      <!-- Alert -->
      <div class="alert">Silakan periksa kembali data di atas, pastikan sudah benar sebelum meminjam buku! Jika ada kesalahan data, harap hubungi admin.</div>

      <!-- Form Pinjam Buku -->
      <div class="card mt-4">
        <div class="card-header">Form Pinjam Buku</div>
        <div class="card-body">
          <form action="" method="post">
            <!-- Ambil data id buku -->
            <?php foreach ($query as $item) : ?>
              <div class="input-group">
                <span>Id Buku</span>
                <input type="text" name="id_buku" value="<?= $item["id_buku"]; ?>" readonly>
              </div>
            <?php endforeach; ?>
            <!-- Ambil data NISN user yang login -->
            <div class="input-group">
              <span>NISN</span>
              <input type="number" name="nisn" value="<?= $_SESSION["member"]["nisn"]; ?>" readonly>
            </div>
            <!-- Admin -->
            <form method="POST" action="pinjamBuku.php">
              <select name="id" required>
                <option value="">Pilih Admin</option>
                <?php foreach ($idAdmin as $item) : ?>
                  <option value="<?= $item["id"]; ?>"><?= $item["id"]; ?></option>
                <?php endforeach; ?>
              </select>

            <!-- Tanggal Pinjam & Pengembalian -->
            <div class="input-group">
              <span>Tanggal Pinjam</span>
              <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" required>
            </div>
            <div class="input-group">
              <span>Tenggat Pengembalian</span>
              <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" readonly>
            </div>

            <a href="../buku/daftarBuku.php" class="btn btn-danger">Batal</a>
            <button type="submit" name="pinjam" class="btn btn-success">Pinjam</button>
          </form>
        </div>
      </div>

      <!-- Catatan -->
      <div class="alert mt-4"><strong>Catatan:</strong> Setiap keterlambatan pengembalian buku akan dikenakan denda.</div>
    </div>

    <!-- Footer -->
    <footer>
      <p>Created by <span class="text-primary">Perpustakaan MTs MMH</span> © 2024 | Versi 1.0</p>
    </footer>

    <script src="../../scripts/pinjamBuku.js"></script>
  </body>
</html>
