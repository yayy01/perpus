<?php
// Database Configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "perpustakaan";

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database_name);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch data from the database
function queryReadData($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Error: " . mysqli_error($connection));
    }
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// Function to execute insert, update, or delete queries
function executeQuery($query) {
    global $connection;
    if (mysqli_query($connection, $query)) {
        return mysqli_affected_rows($connection);
    } else {
        die("Error: " . mysqli_error($connection));
    }
}

// Function to add a book
function tambahBuku($data, $cover) {
    global $connection;

    // Extract data from form
    $id_buku = htmlspecialchars($data["id_buku"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $judul = htmlspecialchars($data["judul"]);
    $pengarang = htmlspecialchars($data["pengarang"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $tahun_terbit = htmlspecialchars($data["tahun_terbit"]);
    $jumlah_halaman = htmlspecialchars($data["jumlah_halaman"]);
    $buku_deskripsi = htmlspecialchars($data["buku_deskripsi"]);

    // Query untuk memasukkan data ke database menggunakan prepared statement
    $query = "INSERT INTO buku 
              (id_buku, kategori, judul, pengarang, penerbit, tahun_terbit, jumlah_halaman, buku_deskripsi, cover)
              VALUES 
              (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Siapkan query untuk di-prepare
    $stmt = mysqli_prepare($connection, $query);

    // Cek apakah prepared statement berhasil disiapkan
    if ($stmt === false) {
        // Jika gagal menyiapkan statement, tampilkan error dan return
        echo "Error preparing statement: " . mysqli_error($connection);
        return 0;
    }

    // Bind parameters untuk prepared statement
    // Pastikan ada 9 parameter dan tipe sesuai dengan query
    // Tipe: s = string, i = integer
    $bind_result = mysqli_stmt_bind_param($stmt, "ssssssiiss", 
        $id_buku, 
        $kategori, 
        $judul, 
        $pengarang, 
        $penerbit, 
        $tahun_terbit, 
        $jumlah_halaman, 
        $buku_deskripsi, 
        $cover
    );

    // Cek apakah binding berhasil
    if (!$bind_result) {
        echo "Error binding parameters: " . mysqli_error($connection);
        mysqli_stmt_close($stmt); // Menutup prepared statement jika terjadi kesalahan
        return 0;
    }

    // Eksekusi prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Jika eksekusi berhasil, kembalikan jumlah baris yang terpengaruh
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt); // Menutup prepared statement setelah eksekusi berhasil
        return $affected_rows;
    } else {
        // Jika eksekusi gagal, tampilkan error
        echo "Error executing statement: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt); // Menutup prepared statement jika eksekusi gagal
        return 0;
    }
}


// Function to upload a file
function uploadFile($file, $uploadPath = '../../imgDB/') {
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $fileError = $file["error"];
    $tmpName = $file["tmp_name"];

    if ($fileError === 4) {
        echo "<script>alert('Please upload a file!');</script>";
        return false;
    }

    // Validasi ekstensi file
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'bmp', 'psd', 'tiff'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Invalid file format!');</script>";
        return false;
    }

    // Validasi ukuran file
    if ($fileSize > 2000000) {
        echo "<script>alert('File size is too large!');</script>";
        return false;
    }

    // Validasi direktori upload
    if (!is_dir($uploadPath) || !is_writable($uploadPath)) {
        echo "<script>alert('Upload directory does not exist or is not writable!');</script>";
        return false;
    }

    // Membuat nama file baru yang unik
    $newFileName = uniqid() . '.' . $fileExtension;

    // Cek apakah file berhasil dipindahkan
    if (!move_uploaded_file($tmpName, $uploadPath . $newFileName)) {
        echo "<script>alert('Failed to upload file!');</script>";
        return false;
    }

    return $newFileName;
}


// Function to delete data from the 'pengembalian' table
function deleteDataPengembalian($idPengembalian) {
    global $connection;
    $query = "DELETE FROM pengembalian WHERE id_pengembalian = ?";
    $stmt = $connection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $idPengembalian);
        $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        return $affectedRows;
    }
    return 0;
}

// Function to search for member
function searchMember($keyword) {
    global $connection;
    $keyword = mysqli_real_escape_string($connection, $keyword);
    $query = "SELECT * FROM member WHERE 
        nisn LIKE '%$keyword%' OR
        kode_member LIKE '%$keyword%' OR
        nama LIKE '%$keyword%' OR
        kelas LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%' OR
        no_tlp LIKE '%$keyword%'";
    return queryReadData($query);
}

// Function to delete a member
function deleteMember($nisn) {
    global $connection;
    $nisn = mysqli_real_escape_string($connection, $nisn);
    $query = "DELETE FROM member WHERE nisn = '$nisn'";
    return mysqli_query($connection, $query);
}

// Function to search books
function search($keyword) {
    global $connection;
    $keyword = mysqli_real_escape_string($connection, $keyword);
    $query = "SELECT * FROM buku WHERE
        judul LIKE '%$keyword%' OR
        kategori LIKE '%$keyword%' OR
        id_buku LIKE '%$keyword%'";
    return queryReadData($query);
}

// Function for member sign-up
function signUp($data) {
    global $connection;

    $nisn = htmlspecialchars($data["nisn"]);
    $kode_member = htmlspecialchars($data["kode_member"]);
    $nama = htmlspecialchars($data["nama"]);
    $passwordPlain = htmlspecialchars($data["password"]);
    $confirmPw = htmlspecialchars($data["confirmPw"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $kelas = htmlspecialchars($data["kelas"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $no_tlp = htmlspecialchars($data["no_tlp"]);
    $tgl_pendaftaran = htmlspecialchars($data["tgl_pendaftaran"]);

    if ($passwordPlain !== $confirmPw) {
        echo "<script>alert('Passwords do not match!');</script>";
        return false;
    }

    $hashedPassword = password_hash($passwordPlain, PASSWORD_DEFAULT);

    $result = $connection->query("SELECT nisn FROM member WHERE nisn = '$nisn' OR kode_member = '$kode_member'");
    if ($result->num_rows > 0) {
        echo "<script>alert('NISN or Member Code already exists!');</script>";
        return false;
    }

    $query = "INSERT INTO member (nisn, kode_member, nama, password, jenis_kelamin, kelas, jurusan, no_tlp, tgl_pendaftaran)
              VALUES ('$nisn', '$kode_member', '$nama', '$hashedPassword', '$jenis_kelamin', '$kelas', '$jurusan', '$no_tlp', '$tgl_pendaftaran')";

    if ($connection->query($query) === TRUE) {
        return true;
    } else {
        echo "<script>alert('Error: " . $connection->error . "');</script>";
        return false;
    }
}

// Fungsi untuk meminjam buku
function pinjamBuku($data) {
    global $connection;

    // Ambil data dari $_POST atau parameter $data
    $idBuku = $data['id_buku'];
    $nisn = $data['nisn'];
    $idAdmin = $data['id'];
    $tglPinjam = $data['tgl_peminjaman'];
    $tglKembali = $data['tgl_pengembalian'];

    // Sanitasi input untuk mencegah SQL Injection
    $idBuku = mysqli_real_escape_string($connection, $idBuku);
    $nisn = mysqli_real_escape_string($connection, $nisn);
    $idAdmin = mysqli_real_escape_string($connection, $idAdmin);
    $tglPinjam = mysqli_real_escape_string($connection, $tglPinjam);
    $tglKembali = mysqli_real_escape_string($connection, $tglKembali);

    // Query untuk memasukkan data peminjaman
    $query = "INSERT INTO peminjaman (id_buku, nisn, id_admin, tgl_peminjaman, tgl_pengembalian) 
              VALUES ('$idBuku', '$nisn', '$idAdmin', '$tglPinjam', '$tglKembali')";
    
    // Eksekusi query
    if (mysqli_query($connection, $query)) {
        return 1; // Berhasil
    } else {
        // Jika gagal, tampilkan pesan error
        return 0; // Gagal
    }
}

function kembalikanBuku($data) {
    global $connection;

    // Ambil data yang dibutuhkan
    $idBuku = $data['id_buku'];
    $nisn = $data['nisn']; // NISN atau ID member yang meminjam buku
    $tanggalKembali = date("Y-m-d H:i:s"); // Menyimpan tanggal dan waktu pengembalian

    // Query untuk mengecek apakah buku ini sedang dipinjam oleh member
    $query = "SELECT * FROM peminjaman WHERE id_buku = '$idBuku' AND nisn = '$nisn' AND status = 'dipinjam'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika buku ditemukan sebagai buku yang dipinjam, lanjutkan untuk mengupdate status
        // Update status peminjaman menjadi 'kembali'
        $updateQuery = "UPDATE peminjaman SET status = 'kembali', tanggal_kembali = '$tanggalKembali' WHERE id_buku = '$idBuku' AND nisn = '$nisn' AND status = 'dipinjam'";

        if (mysqli_query($connection, $updateQuery)) {
            // Update stok buku setelah pengembalian
            $updateStokQuery = "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$idBuku'";

            if (mysqli_query($connection, $updateStokQuery)) {
                return "Buku berhasil dikembalikan!";
            } else {
                return "Gagal memperbarui stok buku.";
            }
        } else {
            return "Gagal mengembalikan buku. Coba lagi.";
        }
    } else {
        return "Buku ini tidak ditemukan dalam peminjaman aktif.";
    }
}

?>

