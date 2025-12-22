<?php
class PencatatController extends Controller {
    
    public function index() {
        $data['judul'] = 'Dashboard Pencatat';
        // Kita arahkan ke view dashboard khusus pencatat
        $this->view('pencatat/dashboard', $data);
    }
    
    // Halaman Form Setor Sampah
    public function setorSampah() {
        // Kita butuh data Nasabah dan Jenis Sampah untuk diisi di form
        $nasabahModel = $this->model('NasabahModel');
        $sampahModel = $this->model('MasterSampah');

        $data['nasabah'] = $nasabahModel->getAll();
        $data['sampah'] = $sampahModel->getAll();
        
        $this->view('pencatat/form_setoran', $data);
    }

    // Proses Simpan Transaksi
    public function prosesSetor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Ambil Data dari Form
            $data = [
                'id_nasabah' => $_POST['id_nasabah'],
                'id_sampah' => $_POST['id_sampah'],
                'berat' => $_POST['berat'],
                'total_harga' => $_POST['total_harga'] // Ini hasil hitungan JS, tapi sebaiknya dihitung ulang di server untuk keamanan
            ];

            // Validasi sederhana
            if (empty($data['id_nasabah']) || empty($data['berat'])) {
                echo "<script>alert('Mohon lengkapi data nasabah dan berat!'); window.history.back();</script>";
                return;
            }

            // 2. Simpan Transaksi & Update Saldo Nasabah
            $transaksiModel = $this->model('TransaksiModel');
            $nasabahModel = $this->model('NasabahModel');

            // Mulai proses simpan
            if ($transaksiModel->tambahSetoran($data)) {
                // Jika transaksi berhasil disimpan, langsung tambah saldo nasabah
                $nasabahModel->tambahSaldo($data['id_nasabah'], $data['total_harga']);

                echo "<script>
                        alert('Berhasil! Transaksi disimpan dan saldo nasabah bertambah Rp " . number_format($data['total_harga'],0,',','.') . "');
                        window.location='index.php?page=setor_sampah';
                      </script>";
            } else {
                echo "<script>alert('Gagal menyimpan transaksi. Cek database.'); window.history.back();</script>";
            }
        }
    }
}