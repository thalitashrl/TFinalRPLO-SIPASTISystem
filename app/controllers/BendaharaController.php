<?php
class BendaharaController extends Controller {
    
    public function index() {
        $data['judul'] = 'Dashboard Bendahara';

        // Panggil Model
        $transaksiModel = $this->model('TransaksiModel');

        // Ambil data Saldo Kas lewat Model (Bukan query langsung di sini)
        $data['stats']['kas'] = $transaksiModel->getSaldoKas();

        // Tampilkan View
        $this->view('bendahara/dashboard', $data);
    }

    // Halaman Validasi
    public function validasiPenarikan() {
        $data['judul'] = 'Validasi Penarikan';
        $transaksiModel = $this->model('TransaksiModel');
        
        // Data 1: Permintaan Baru (Pending)
        $data['request'] = $transaksiModel->getPendingPenarikan();
        
        // Data 2: Riwayat Selesai (Approved/Rejected) -- TAMBAHAN INI
        $data['riwayat'] = $transaksiModel->getRiwayatValidasi();
        
        $this->view('bendahara/validasi', $data);
    }

    // Proses Terima/Tolak
    public function prosesValidasi() {
        if (isset($_GET['id']) && isset($_GET['aksi'])) {
            $id = $_GET['id'];
            $aksi = $_GET['aksi']; // 'approve' atau 'reject'
            
            $status = ($aksi == 'approve') ? 'approved' : 'rejected';
            
            if ($this->model('TransaksiModel')->updateStatusPenarikan($id, $status)) {
                echo "<script>alert('Status berhasil diperbarui!'); window.location='index.php?page=validasi';</script>";
            }
        }
    }
}