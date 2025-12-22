<?php
// app/controllers/AuthProcess.php (Simulasi Logika)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query ke tabel pengguna
    $query = "SELECT * FROM pengguna WHERE username = '$user'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Menggunakan password_verify jika password di-hash
        if (password_verify($pass, $data['password']) || $pass == $data['password']) {
            $_SESSION['id_user'] = $data['id_pengguna'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['role'] = $data['role']; 

            header("Location: index.php?page=dashboard");
            exit();
        }
    }
    // Jika gagal, kembali ke login dengan pesan error
    header("Location: index.php?page=login&error=1");
}