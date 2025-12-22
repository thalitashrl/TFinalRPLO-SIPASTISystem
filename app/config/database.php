<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "si_pasti";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        } catch (Exception $e) {
            echo "Koneksi Gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
}