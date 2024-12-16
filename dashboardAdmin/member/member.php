<?php
session_start();

// Pastikan fungsi queryReadData dan searchMember ada di config.php
require "../../data/config.php";

// Ambil data member jika form pencarian tidak disubmit
$member = queryReadData("SELECT * FROM member");

// Jika form pencarian disubmit
if (isset($_POST["search"])) {
    $keyword = $_POST["keyword"];
    $member = searchMember($keyword);  // Pastikan fungsi searchMember terdefinisi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/admin/admin-member.css">
    <title>Member Terdaftar || Admin</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-container">
        <a href="#">
          <img src="../../images/logoNav.png" alt="logo" class="logo">
        </a>
        <a class="dashboard-btn" href="../dashboard.php">Dashboard</a>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <form action="" method="post" class="search-form">
            <input  class="search-input" type="text" name="keyword" id="keyword" placeholder="Cari data member...">
            <button class="search-button" type="submit" name="search">Cari</button>
        </form>

        <!-- Tabel Data Member -->
        <section class="table-section"></section>
        <h2>List of Members</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No Telepon</th>
                        <th>Pendaftaran</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($member as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item["nisn"]); ?></td>
                            <td><?= htmlspecialchars($item["kode_member"]); ?></td>
                            <td><?= htmlspecialchars($item["nama"]); ?></td>
                            <td><?= htmlspecialchars($item["jenis_kelamin"]); ?></td>
                            <td><?= htmlspecialchars($item["kelas"]); ?></td>
                            <td><?= htmlspecialchars($item["jurusan"]); ?></td>
                            <td><?= htmlspecialchars($item["no_tlp"]); ?></td>
                            <td><?= htmlspecialchars($item["tgl_pendaftaran"]); ?></td>
                            <td>
                                <a href="deleteMember.php?id=<?= urlencode($item["nisn"]); ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus data member?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p>Created by <span class="author">Muya</span> &copy; 2024</p>
            <p>Versi 1.0</p>
        </div>
    </footer>
</body>
</html>
