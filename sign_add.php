<?php
// Pastikan file 'db.php' di-include dan koneksi database berhasil
include 'db.php'; // Periksa lokasi file ini

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dan bersihkan (sanitize)
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($password)) {
        echo "Email atau password tidak boleh kosong.";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data
    $query = "INSERT INTO sign_up (email, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);

    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt) {
        // Bind parameter dan eksekusi query
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            echo "Registrasi berhasil!";
            echo '<br><a href="sign_read.php">Lihat Data</a>';
        } else {
            // Menampilkan error jika query gagal
            echo "Gagal menyimpan data: " . mysqli_error($koneksi);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal mempersiapkan query: " . mysqli_error($koneksi);
    }

    // Tutup koneksi
    mysqli_close($koneksi);
} else {
    echo "Form belum disubmit.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <h2>Form Registrasi</h2>
    <form action="http://localhost:8080/CONVERSE_DATABASE/php/proses_daftar.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
