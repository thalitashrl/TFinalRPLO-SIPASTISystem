<?php
// app/controllers/AdminController.php

class AdminController extends Controller {
    
    public function index() {
        $data['judul'] = 'Dashboard Admin';
        
        // Panggil Model
        $nasabahModel = $this->model('NasabahModel');
        $transaksiModel = $this->model('TransaksiModel');

        // Siapkan Data Statistik
        $data['stats'] = [
            'nasabah' => $nasabahModel->countNasabah(),
            'total_sampah' => $transaksiModel->getTotalBeratSampah(),
            'uang_nasabah' => $nasabahModel->getTotalTabungan()
        ];

        // Kirim ke View (PENTING: variabel $data dikirim di sini)
        $this->view('admin/dashboard', $data);
    }

    // Halaman Kelola Pengguna
    public function kelolaPengguna() {
        $userModel = $this->model('UserModel');
        
        // Panggil fungsi getAllStaf()
        $data['pengguna'] = $userModel->getAllStaf();
        
        $this->view('admin/kelola_pengguna', $data);
    }

    // Proses Tambah User Baru
    public function tambahUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            
            // Logika khusus Nasabah
            if ($_POST['role'] == 'Nasabah') {
                if ($userModel->tambahNasabah($_POST)) {
                    echo "<script>alert('Nasabah baru berhasil ditambahkan!'); window.location='index.php?page=data_nasabah';</script>";
                } else {
                    echo "<script>alert('Gagal menambah nasabah.'); window.history.back();</script>";
                }
            } else {
                // Logika untuk Staf (Admin/Pencatat/Bendahara)
                if ($userModel->tambahStaf($_POST)) {
                    echo "<script>alert('Staf baru berhasil ditambahkan!'); window.location='index.php?page=kelola_pengguna';</script>";
                } else {
                    echo "<script>alert('Gagal menambah staf.'); window.history.back();</script>";
                }
            }
            exit;
        }
    }

    // --- FITUR KELOLA PENGGUNA (STAF) ---

    public function editPengguna($id) {
        $userModel = $this->model('UserModel');
        $data['u'] = $userModel->getUserById($id);
        $this->view('admin/edit_pengguna', $data);
    }

    public function prosesEditPengguna() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('UserModel')->updateStaf($_POST)) {
                echo "<script>alert('Data pengguna berhasil diperbarui!'); window.location='index.php?page=kelola_pengguna';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data.'); window.location='index.php?page=kelola_pengguna';</script>";
            }
        }
    }

    public function hapusPengguna($id) {
        if ($this->model('UserModel')->deleteStaf($id)) {
            echo "<script>alert('Pengguna berhasil dihapus!'); window.location='index.php?page=kelola_pengguna';</script>";
        } else {
            echo "<script>alert('Gagal menghapus! Anda tidak bisa menghapus akun yang sedang login.'); window.location='index.php?page=kelola_pengguna';</script>";
        }
    }

    // Menampilkan Data Sampah
    public function dataSampah() {
        $sampahModel = $this->model('MasterSampah');
        $data['sampah'] = $sampahModel->getAll();
        $this->view('admin/data_sampah', $data);
    }

    // Tambahkan di dalam class AdminController

public function prosesTambahSampah() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($this->model('MasterSampah')->tambah($_POST)) {
            header('Location: index.php?page=data_sampah&status=success');
        } else {
            header('Location: index.php?page=data_sampah&status=failed');
        }
    }
}

public function editSampah($id) {
    if (empty($id)) {
        header("Location: index.php?page=data_sampah");
        exit;
    }
    $data['s'] = $this->model('MasterSampah')->getById($id);
    $this->view('admin/edit_sampah', $data);
}

// Proses Edit Sampah
    public function prosesEditSampah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sampahModel = $this->model('MasterSampah');
            
            if ($sampahModel->update($_POST)) {
                // Redirect jika sukses
                echo "<script>alert('Data sampah berhasil diperbarui!'); window.location='index.php?page=data_sampah';</script>";
            } else {
                // Alert jika gagal
                echo "<script>alert('Gagal memperbarui data.'); window.location='index.php?page=data_sampah';</script>";
            }
            exit;
        }
    }

public function hapusSampah($id) {
    if ($this->model('MasterSampah')->delete($id)) {
        header('Location: index.php?page=data_sampah&status=deleted');
    }
}

    // Menampilkan Data Nasabah
    public function dataNasabah() {
        $nasabahModel = $this->model('NasabahModel');
        
        // Cek apakah ada input pencarian
        $keyword = isset($_GET['search']) ? $_GET['search'] : null;
        
        if ($keyword) {
            $data['nasabah'] = $nasabahModel->search($keyword);
        } else {
            $data['nasabah'] = $nasabahModel->getAll();
        }
        
        $this->view('admin/data_nasabah', $data);
    }

    // Form Edit Nasabah
    public function editNasabah($id) {
        $nasabahModel = $this->model('NasabahModel');
        $data['n'] = $nasabahModel->getById($id);
        $this->view('admin/edit_nasabah', $data);
    }

    // Proses Update Nasabah
    public function prosesEditNasabah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Pastikan model sudah diload
            $nasabahModel = $this->model('NasabahModel');
            
            if ($nasabahModel->updateNasabah($_POST)) {
                // Redirect kembali ke halaman data nasabah dengan pesan sukses
                echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php?page=data_nasabah';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data.'); window.location='index.php?page=data_nasabah';</script>";
            }
            exit;
        }
    }

    // Proses Hapus Nasabah
    public function hapusNasabah($id) {
        $nasabahModel = $this->model('NasabahModel');
        if ($nasabahModel->delete($id)) {
            header('Location: index.php?page=data_nasabah&status=deleted');
        }
        exit;
    }

    // Proses Hapus User (Opsional, untuk melengkapi CRUD)
    public function hapusUser($id) {
        // Logika hapus bisa ditambahkan di sini nanti
    }

    // --- FITUR LAPORAN KEUANGAN ---

    public function laporanKeuangan() {
        $transaksiModel = $this->model('TransaksiModel');

        // Ambil Data Ringkasan
        $setoran = $transaksiModel->getTotalSetoran();     // Uang masuk ke Nasabah (Hutang BSU)
        $penjualan = $transaksiModel->getTotalPenjualan(); // Uang masuk Riil dari Pengepul
        $penarikan = $transaksiModel->getTotalPenarikan(); // Uang keluar ke Nasabah

        // Rumus Margin & Saldo BSU (Sesuai Logika Akuntansi Sampah)
        // Margin = Penjualan (Harga Pusat) - Setoran (Harga Nasabah)
        // Note: Ini hitungan kasar global. Idealnya per transaksi.
        // Untuk tahap ini, kita asumsikan Margin adalah selisih global dulu.
        $margin = $penjualan > 0 ? ($penjualan - $setoran) : 0; 
        
        // Saldo Kas BSU (Uang Riil di Tangan Admin)
        // Rumus: (Modal Awal + Penjualan) - Penarikan
        // Kita sederhanakan: Penjualan - Penarikan (Asumsi saldo awal 0)
        $saldo_bsu = $penjualan - $penarikan; 

        // Kirim ke View
        $data['keuangan'] = [
            'total_setoran' => $setoran,
            'total_penjualan' => $penjualan,
            'margin_keuntungan' => $margin, 
            'total_penarikan' => $penarikan,
            'saldo_bsu' => $saldo_bsu
        ];

        // Ambil list transaksi untuk tabel bawah
        $data['riwayat'] = $transaksiModel->getRiwayatTransaksi(10);

        $this->view('admin/laporan_keuangan', $data);
    }

    // --- FITUR PENARIKAN SALDO ---
    
    public function tarikSaldo() {
        $nasabahModel = $this->model('NasabahModel');
        $data['nasabah'] = $nasabahModel->getAll();
        
        // Jika ada ID nasabah dipilih di URL, ambil saldonya
        if (isset($_GET['id'])) {
            $data['saldo_saat_ini'] = $nasabahModel->getSaldo($_GET['id']);
        }
        
        $this->view('admin/form_penarikan', $data);
    }

    public function prosesPenarikan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_nasabah = $_POST['id_nasabah'];
            $jumlah = $_POST['jumlah_penarikan'];
            
            // Ambil saldo real-time dari database (untuk keamanan ganda)
            $nasabahModel = $this->model('NasabahModel');
            $saldoReal = $nasabahModel->getSaldo($id_nasabah);

            // Validasi: Apakah saldo cukup?
            if ($saldoReal < $jumlah) {
                echo "<script>alert('Gagal! Saldo tidak mencukupi. Sisa saldo: Rp " . number_format($saldoReal) . "'); window.history.back();</script>";
                return;
            }

            // Proses Penarikan
            $transaksiModel = $this->model('TransaksiModel');
            
            if ($transaksiModel->tambahPenarikan($_POST)) {
                // Kurangi Saldo
                $nasabahModel->kurangiSaldo($id_nasabah, $jumlah);
                echo "<script>alert('Penarikan Berhasil!'); window.location='index.php?page=tarik_saldo';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan transaksi.'); window.history.back();</script>";
            }
        }
    }

    // --- FITUR PENJUALAN SAMPAH (KE PENGEPUL) ---

    public function jualSampah() {
        // Kita butuh data sampah untuk dropdown
        $sampahModel = $this->model('MasterSampah');
        $data['sampah'] = $sampahModel->getAll();
        
        $this->view('admin/form_penjualan', $data);
    }

    public function prosesJual() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi input
            if(empty($_POST['tujuan_pengepul']) || empty($_POST['berat'])) {
                 echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
                 return;
            }

            // Hitung Total Pendapatan secara manual di backend (untuk validasi)
            // (Opsional: Bisa ambil harga dari Master Data atau input manual)
            // Di sini kita percaya input form dulu
            
            if ($this->model('TransaksiModel')->tambahPenjualan($_POST)) {
                echo "<script>alert('Penjualan Berhasil! Kas BSU bertambah.'); window.location='index.php?page=laporan_keuangan';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan transaksi.'); window.history.back();</script>";
            }
        }
    }

    // --- FITUR CETAK LAPORAN (PDF) ---
    public function cetakLaporan() {
        // 1. Ambil Filter Bulan
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
        
        $data['bulan'] = $bulan;
        $data['judul'] = 'Laporan Keuangan - ' . $bulan;
        
        // 2. Panggil Model (PERBAIKAN DI SINI)
        $transaksiModel = $this->model('TransaksiModel');
        
        // Ambil data lewat fungsi model yang baru kita buat
        $data['transaksi'] = $transaksiModel->getLaporanBulanan($bulan);

        // 3. Panggil View Khusus Cetak
        $this->view('admin/cetak_laporan', $data);
    }
    
}