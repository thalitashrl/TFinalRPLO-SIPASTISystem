<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getByUsername($username) {
        // Mencegah SQL Injection sederhana
        $username = $this->db->real_escape_string($username);
        
        $query = "SELECT * FROM pengguna WHERE username = '$username'";
        $result = $this->db->query($query);
        
        // Mengembalikan array asosiatif data user jika ditemukan, atau null jika tidak
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    public function tambahStaf($data) {
        $nama = $data['nama_lengkap']; 
        $user = $data['username']; 
        // Password di-hash saat register/seeding
        $pass = password_hash($data['password'], PASSWORD_DEFAULT); 
        $role = $data['role']; 

        $query = "INSERT INTO pengguna (nama_lengkap, username, password, role) 
                  VALUES ('$nama', '$user', '$pass', '$role')";
        return $this->db->query($query);
    }

    public function tambahNasabah($data) {
        // 1. Ambil data dari form modal Anda
        $nama = mysqli_real_escape_string($this->db, $data['nama_lengkap']);
        $user = mysqli_real_escape_string($this->db, $data['username']);
        $pass = password_hash($data['password'], PASSWORD_DEFAULT); // Hash untuk keamanan
        $alamat = mysqli_real_escape_string($this->db, $data['alamat']);
        $telp = mysqli_real_escape_string($this->db, $data['no_telepon']);

        // 2. Simpan ke tabel pengguna untuk akses login (Session)
        $queryUser = "INSERT INTO pengguna (nama_lengkap, username, password, role) 
                    VALUES ('$nama', '$user', '$pass', 'Nasabah')";
        
        if ($this->db->query($queryUser)) {
            // Ambil ID yang baru saja dibuat oleh sistem
            $id_pengguna = $this->db->insert_id;

            // 3. Simpan ke tabel nasabah (Agar muncul di halaman Data Nasabah)
            // Saldo akhir diatur 0 sesuai kondisi awal nasabah baru
            $queryNasabah = "INSERT INTO nasabah (id_pengguna, alamat, no_telepon, saldo_akhir) 
                            VALUES ('$id_pengguna', '$alamat', '$telp', 0)";
            
            return $this->db->query($queryNasabah);
        }
        return false;
    }

    // Ambil semua pengguna KECUALI yang role-nya Nasabah
    public function getAllStaf() {
        // Kita filter agar Nasabah tidak muncul di menu 'Kelola Pengguna' (karena sudah ada menu sendiri)
        $query = "SELECT * FROM pengguna WHERE role != 'Nasabah' ORDER BY role ASC, nama_lengkap ASC";
        return $this->db->query($query);
    }

    // Ambil data satu pengguna untuk diedit
    public function getUserById($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        $query = "SELECT * FROM pengguna WHERE id_pengguna = '$id'";
        return $this->db->query($query)->fetch_assoc();
    }

    // Update Data Staf (Admin/Pencatat/Bendahara)
    public function updateStaf($data) {
        $id = mysqli_real_escape_string($this->db, $data['id_pengguna']);
        $nama = mysqli_real_escape_string($this->db, $data['nama_lengkap']);
        $user = mysqli_real_escape_string($this->db, $data['username']);
        $role = mysqli_real_escape_string($this->db, $data['role']);

        // Logika Update Password (Hanya update jika kolom password diisi)
        if (!empty($data['password'])) {
            $pass = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = "UPDATE pengguna SET 
                      nama_lengkap = '$nama', 
                      username = '$user', 
                      password = '$pass', 
                      role = '$role' 
                      WHERE id_pengguna = '$id'";
        } else {
            // Jika password kosong, jangan diubah
            $query = "UPDATE pengguna SET 
                      nama_lengkap = '$nama', 
                      username = '$user', 
                      role = '$role' 
                      WHERE id_pengguna = '$id'";
        }
        
        return $this->db->query($query);
    }

    // Hapus Staf
    public function deleteStaf($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        // Mencegah menghapus diri sendiri (Opsional, tapi disarankan)
        if ($id == $_SESSION['user_id']) {
            return false; 
        }
        return $this->db->query("DELETE FROM pengguna WHERE id_pengguna = '$id'");
    }
}