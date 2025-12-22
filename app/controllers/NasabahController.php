<?php
class NasabahController extends Controller {
    
    // Helper: Dapatkan ID Nasabah dengan aman
    private function getIdNasabah() {
        // PERBAIKAN: Gunakan kunci 'id_user' sesuai hasil diagnosa session Anda
        if (!isset($_SESSION['id_user'])) {
            return 0; // Kembalikan 0 jika session hilang
        }

        $id_user = $_SESSION['id_user']; // <-- INI YANG SUDAH DIPERBAIKI
        $nasabahModel = $this->model('NasabahModel');
        
        return $nasabahModel->getIdByUserId($id_user);
    }

    public function index() {
        // Cek Login
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Nasabah') {
            header("Location: index.php?page=login");
            exit;
        }

        $data['judul'] = 'Dashboard Nasabah';
        
        $id_nasabah = $this->getIdNasabah();
        
        // Jika session tidak valid, lempar ke login
        if ($id_nasabah === 0) {
            header("Location: index.php?page=login");
            exit;
        }

        $nasabahModel = $this->model('NasabahModel');
        $transaksiModel = $this->model('TransaksiModel');

        $data['stats'] = [
            'saldo' => $nasabahModel->getSaldo($id_nasabah),
            'total_berat' => $transaksiModel->getTotalBeratByNasabah($id_nasabah),
            'total_tarik' => $transaksiModel->getTotalPenarikanByNasabah($id_nasabah)
        ];

        $this->view('nasabah/dashboard', $data);
    }

    public function riwayatTransaksi() {
        // Cek Login
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Nasabah') {
            header("Location: index.php?page=login");
            exit;
        }

        $data['judul'] = 'Riwayat Transaksi';
        $id_nasabah = $this->getIdNasabah();
        
        if ($id_nasabah === 0) {
            header("Location: index.php?page=login");
            exit;
        }

        $transaksiModel = $this->model('TransaksiModel');
        $nasabahModel = $this->model('NasabahModel');

        $data['saldo'] = $nasabahModel->getSaldo($id_nasabah);
        
        // PERBAIKAN: Gunakan 'id_user' di sini juga untuk mengambil riwayat
        $data['riwayat'] = $transaksiModel->getRiwayatPerNasabah($_SESSION['id_user']); 

        $this->view('nasabah/riwayat', $data);
    }
}