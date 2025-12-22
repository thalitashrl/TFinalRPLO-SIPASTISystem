<?php
class NasabahModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Mengambil semua nasabah dengan menggabungkan tabel pengguna
    public function getAll() {
        // Kita JOIN dengan tabel pengguna agar bisa mengambil kolom nama_lengkap
        $query = "SELECT nasabah.*, pengguna.nama_lengkap 
                  FROM nasabah 
                  JOIN pengguna ON nasabah.id_pengguna = pengguna.id_pengguna 
                  ORDER BY pengguna.nama_lengkap ASC";
        return $this->db->query($query);
    }

    // Mengambil satu data nasabah untuk proses EDIT
    public function getById($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        $query = "SELECT nasabah.*, pengguna.nama_lengkap 
                  FROM nasabah 
                  JOIN pengguna ON nasabah.id_pengguna = pengguna.id_pengguna 
                  WHERE nasabah.id_nasabah = '$id'";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    // Fungsi Update Data Nasabah
    public function updateNasabah($data) {
        $id_nasabah = mysqli_real_escape_string($this->db, $data['id_nasabah']);
        $nama = mysqli_real_escape_string($this->db, $data['nama_lengkap']);
        $alamat = mysqli_real_escape_string($this->db, $data['alamat']);
        $telp = mysqli_real_escape_string($this->db, $data['no_telepon']);

        // 1. Ambil id_pengguna terlebih dahulu agar bisa update nama di tabel pengguna
        $nasabah = $this->getById($id_nasabah);
        $id_pengguna = $nasabah['id_pengguna'];

        // 2. Update Nama di tabel pengguna
        $this->db->query("UPDATE pengguna SET nama_lengkap = '$nama' WHERE id_pengguna = '$id_pengguna'");

        // 3. Update Alamat dan Telp di tabel nasabah
        $query = "UPDATE nasabah SET 
                  alamat = '$alamat', 
                  no_telepon = '$telp' 
                  WHERE id_nasabah = '$id_nasabah'";
        
        return $this->db->query($query);
    }

    public function search($keyword) {
        $keyword = mysqli_real_escape_string($this->db, $keyword);
        // Mencari berdasarkan nama lengkap atau alamat
        $query = "SELECT nasabah.*, pengguna.nama_lengkap 
                FROM nasabah 
                JOIN pengguna ON nasabah.id_pengguna = pengguna.id_pengguna 
                WHERE pengguna.nama_lengkap LIKE '%$keyword%' 
                OR nasabah.alamat LIKE '%$keyword%'
                ORDER BY pengguna.nama_lengkap ASC";
        return $this->db->query($query);
    }

    // Fungsi Hapus Nasabah (Menghapus Profil & Akun Login)
    public function delete($id) {
        $id = mysqli_real_escape_string($this->db, $id);

        // 1. Kita cari dulu id_pengguna-nya sebelum datanya hilang
        // (Kita butuh ini untuk menghapus akun login di tabel 'pengguna')
        $queryGet = "SELECT id_pengguna FROM nasabah WHERE id_nasabah = '$id'";
        $result = $this->db->query($queryGet);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_pengguna = $row['id_pengguna'];

            // 2. Hapus dulu data profil di tabel 'nasabah' (Anak)
            $deleteNasabah = "DELETE FROM nasabah WHERE id_nasabah = '$id'";
            $this->db->query($deleteNasabah);

            // 3. Hapus data akun di tabel 'pengguna' (Induk)
            $deleteUser = "DELETE FROM pengguna WHERE id_pengguna = '$id_pengguna'";
            return $this->db->query($deleteUser);
        }
        
        return false; // Gagal jika ID tidak ditemukan
    }

    // Fungsi Update Saldo (Menambah uang tabungan)
    public function tambahSaldo($id_nasabah, $nominal) {
        $id = mysqli_real_escape_string($this->db, $id_nasabah);
        $nominal = mysqli_real_escape_string($this->db, $nominal);

        // Update saldo yang ada ditambah nominal baru
        $query = "UPDATE nasabah SET saldo = saldo + $nominal WHERE id_nasabah = '$id'";
        return $this->db->query($query);
    }

    // Ambil Saldo Terakhir Nasabah
    public function getSaldo($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        $query = "SELECT saldo FROM nasabah WHERE id_nasabah = '$id'";
        $result = $this->db->query($query)->fetch_assoc();
        return $result['saldo'] ?? 0;
    }

    // Kurangi Saldo (Untuk Penarikan)
    public function kurangiSaldo($id, $nominal) {
        $id = mysqli_real_escape_string($this->db, $id);
        $nominal = mysqli_real_escape_string($this->db, $nominal);
        
        // Query aman: Saldo berkurang
        $query = "UPDATE nasabah SET saldo = saldo - $nominal WHERE id_nasabah = '$id'";
        return $this->db->query($query);
    }

    // Hitung total nasabah
    public function countNasabah() {
        $query = "SELECT COUNT(*) as total FROM nasabah";
        return $this->db->query($query)->fetch_assoc()['total'];
    }

    // Hitung total uang milik nasabah (Liabilitas BSU)
    public function getTotalTabungan() {
        $query = "SELECT SUM(saldo) as total FROM nasabah";
        $result = $this->db->query($query)->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // --- FUNGSI BARU: Cari ID Nasabah berdasarkan ID User Login ---
    public function getIdByUserId($id_user) {
        $id_user = mysqli_real_escape_string($this->db, $id_user);
        
        $query = "SELECT id_nasabah FROM nasabah WHERE id_pengguna = '$id_user'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id_nasabah'];
        }
        
        // Jika tidak ditemukan, kembalikan ID user itu sendiri (fallback)
        return $id_user;
    }
}