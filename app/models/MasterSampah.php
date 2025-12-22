<?php
class MasterSampah {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM master_sampah ORDER BY nama_sampah ASC");
    }

    // GANTI: Cari berdasarkan kode_sampah
    public function getById($kode) {
        $kode = mysqli_real_escape_string($this->db, $kode);
        $query = "SELECT * FROM master_sampah WHERE kode_sampah = '$kode'";
        return $this->db->query($query)->fetch_assoc();
    }

    public function tambah($data) {
        $nama = mysqli_real_escape_string($this->db, $data['nama_sampah']);
        $harga_beli = mysqli_real_escape_string($this->db, $data['harga_beli']);
        $harga_jual = mysqli_real_escape_string($this->db, $data['harga_jual']);
        
        $kode = "SPH-" . date('ymdHis'); // Generate kode unik

        $query = "INSERT INTO master_sampah (kode_sampah, nama_sampah, harga_beli_per_kg, harga_jual_pusat) 
                  VALUES ('$kode', '$nama', '$harga_beli', '$harga_jual')";
        return $this->db->query($query);
    }

    // GANTI: Update berdasarkan kode_sampah
    public function update($data) {
        $kode = mysqli_real_escape_string($this->db, $data['kode_sampah']); // Kunci Utama
        $nama = mysqli_real_escape_string($this->db, $data['nama_sampah']);
        $harga_beli = mysqli_real_escape_string($this->db, $data['harga_beli_per_kg']);
        $harga_jual = mysqli_real_escape_string($this->db, $data['harga_jual_pusat']);

        $query = "UPDATE master_sampah SET 
                  nama_sampah = '$nama', 
                  harga_beli_per_kg = '$harga_beli', 
                  harga_jual_pusat = '$harga_jual' 
                  WHERE kode_sampah = '$kode'";
        
        return $this->db->query($query);
    }

    // GANTI: Hapus berdasarkan kode_sampah
    public function delete($kode) {
        $kode = mysqli_real_escape_string($this->db, $kode);
        return $this->db->query("DELETE FROM master_sampah WHERE kode_sampah = '$kode'");
    }
}