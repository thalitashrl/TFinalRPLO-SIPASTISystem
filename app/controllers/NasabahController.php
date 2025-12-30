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

    // Form Pengajuan
    public function tarikSaldo() {
        // Cek login & session seperti biasa...
        $data['judul'] = 'Ajukan Penarikan Saldo';
        $id_nasabah = $this->getIdNasabah(); // Gunakan helper yang sudah kita buat
        
        $nasabahModel = $this->model('NasabahModel');
        $data['saldo_aktif'] = $nasabahModel->getSaldo($id_nasabah);
        
        $this->view('nasabah/tarik_saldo', $data);
    }

    // Proses Submit Pengajuan
    public function prosesTarik() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_nasabah = $this->getIdNasabah();
            $jumlah = $_POST['jumlah'];
            $saldo = $_POST['saldo_max']; // Kirim saldo max dari form hidden untuk validasi

            // Validasi Saldo Cukup
            if ($jumlah > $saldo) {
                echo "<script>alert('Saldo tidak mencukupi!'); window.history.back();</script>";
                return;
            }

            $data = [
                'id_nasabah' => $id_nasabah,
                'jumlah' => $jumlah
            ];

            if ($this->model('TransaksiModel')->ajukanPenarikan($data)) {
                echo "<script>alert('Permintaan berhasil dikirim! Menunggu persetujuan Bendahara.'); window.location='index.php?page=riwayat';</script>";
            }
        }
    }
}