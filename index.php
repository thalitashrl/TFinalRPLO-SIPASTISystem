<?php
// session_start();
// echo "<h1>🔍 INTIP ISI SESSION</h1>";
// echo "<pre style='background:#f0f0f0; padding:20px; font-size:16px;'>";
// print_r($_SESSION);
// echo "</pre>";
// echo "<a href='index.php?page=logout' style='background:red; color:white; padding:10px; text-decoration:none;'>PAKSA LOGOUT</a>";
// exit;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// Mengaktifkan Output Buffering untuk mencegah error "Headers already sent"
ob_start();

// Debugging (Bisa dimatikan nanti jika sudah live/hosting)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Memanggil konfigurasi dasar
require_once 'app/config/database.php';
require_once 'app/config/Controller.php';

// Routing Sederhana
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Logic Keamanan: Jika belum login, paksa ke halaman login
// Kecuali sedang di halaman login atau sedang proses login (auth_process)
if (!$role && $page !== 'login' && $page !== 'auth_process') {
    header("Location: index.php?page=login");
    exit();
}

// Logic Router (Switch Case)
switch ($page) {
    
    // 1. Halaman Login
    case 'login':
        // Jika sudah login, lempar ke dashboard
        if ($role) {
            header("Location: index.php?page=dashboard");
            exit();
        }
        require_once 'app/views/auth/login.php';
        break;

    // 2. Halaman Dashboard (Dinamis via Controller)
    case 'dashboard':
        // Cek apakah user sudah login
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];

            // SKENARIO 1: Jika user adalah ADMIN
            if ($role == 'Admin') {
                // Panggil AdminController (Di sini data statistik dihitung)
                require_once 'app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->index(); 
            } 
            
            // SKENARIO 2: Jika user adalah PENCATAT
            elseif ($role == 'Pencatat') {
                // Panggil PencatatController
                require_once 'app/controllers/PencatatController.php';
                $controller = new PencatatController();
                $controller->index();
            }

            // SKENARIO 4: Bendahara
            elseif ($role == 'Bendahara') {
                require_once 'app/controllers/BendaharaController.php';
                $controller = new BendaharaController();
                $controller->index();
            }

            // SKENARIO 4: Nasabah
            elseif ($role == 'Nasabah') {
                require_once 'app/controllers/NasabahController.php';
                $controller = new NasabahController();
                $controller->index();
            }

            
            else {
                // Fallback: Langsung panggil view jika controller belum ada
                $roleFile = strtolower($role);
                $viewPath = "app/views/" . $roleFile . "/dashboard.php";
                
                if (file_exists($viewPath)) {
                    require_once 'app/views/layouts/sidebar.php';
                    require_once $viewPath;
                } else {
                    echo "<h3>Dashboard untuk role $role belum tersedia.</h3>";
                }
            }

        } else {
            // Jika belum login, lempar ke halaman login
            header("Location: index.php?page=login");
            exit;
        }
        break;

    // --- MENU ADMIN: KELOLA PENGGUNA ---
    case 'kelola_pengguna':
        // Cek apakah yang akses benar-benar Admin
        if ($role == 'Admin') {
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->kelolaPengguna(); // Panggil fungsi tampilkan halaman
        } else {
            // Jika bukan admin coba akses, tendang ke dashboard
            header("Location: index.php?page=dashboard");
        }
        break;

    case 'proses_tambah_user':
        if ($role == 'Admin') {
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->tambahUser(); // Panggil fungsi proses tambah
        }
        break;

    // Router untuk Kelola Pengguna
// --- FITUR KELOLA PENGGUNA (STAF) ---

    case 'edit_pengguna':
        // Cek Login & Role (Opsional tapi disarankan)
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
            // PERBAIKAN: Panggil file controller dulu!
            require_once 'app/controllers/AdminController.php'; 
            
            $controller = new AdminController();
            $controller->editPengguna($_GET['id']);
        }
        break;

    case 'proses_edit_pengguna':
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
            // PERBAIKAN: Panggil file controller dulu!
            require_once 'app/controllers/AdminController.php';
            
            $controller = new AdminController();
            $controller->prosesEditPengguna();
        }
        break;

    case 'hapus_pengguna':
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
            // PERBAIKAN: Panggil file controller dulu!
            require_once 'app/controllers/AdminController.php';
            
            $controller = new AdminController();
            $controller->hapusPengguna($_GET['id']);
        }
        break;

    // --- MASTER DATA: DATA SAMPAH ---
    case 'data_sampah':
        if ($role == 'Admin') {
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->dataSampah();
        }
        break;

    case 'proses_tambah_sampah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        (new AdminController())->prosesTambahSampah();
    }
    break;
case 'edit_sampah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        (new AdminController())->editSampah($_GET['id']);
    }
    break;
case 'proses_edit_sampah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        (new AdminController())->prosesEditSampah();
    }
    break;
case 'hapus_sampah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        (new AdminController())->hapusSampah($_GET['id']);
    }
    break;

    // --- MASTER DATA: DATA NASABAH ---
    case 'data_nasabah':
        if ($role == 'Admin') {
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->dataNasabah();
        }
        break;
    
    case 'edit_nasabah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->editNasabah($_GET['id']);
    }
    break;

case 'proses_edit_nasabah':
    if ($_SESSION['role'] == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->prosesEditNasabah();
    }
    break;

case 'hapus_nasabah':
    if ($role == 'Admin') {
        require_once 'app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->hapusNasabah($_GET['id']);
    }
    break;

// --- RUTE LAPORAN KEUANGAN ---
    // case 'laporan_keuangan':
    //     // Cek apakah user sudah login DAN role-nya Admin
    //     if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    //         require_once 'app/controllers/AdminController.php'; // PENTING: Panggil Controller dulu
    //         $controller = new AdminController();
    //         $controller->laporanKeuangan();
    //     } else {
    //         // Jika bukan Admin, tendang ke login
    //         header("Location: index.php?page=login");
    //         exit;
    //     }
    //     break;

    // --- LAPORAN KEUANGAN ---
    case 'laporan_keuangan':
        // IZINKAN: Admin, Pencatat, DAN Bendahara
        if (isset($_SESSION['role']) && 
           ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Pencatat' || $_SESSION['role'] == 'Bendahara')) {
            
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->laporanKeuangan();
            
        } else {
            // Jika role lain (misal Nasabah) mencoba masuk, tolak
            echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.history.back();</script>";
        }
        break;

    // --- CETAK LAPORAN ---
    case 'cetak_laporan':
        // Izinkan Admin dan Bendahara
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Bendahara')) {
            require_once 'app/controllers/AdminController.php';
            (new AdminController())->cetakLaporan();
        } else {
            header("Location: index.php?page=login");
        }
        break;

    
    // --- MODUL PENCATAT (TRANSAKSI) ---
    // Update: Tambahkan 'case setoran' agar sesuai dengan link di Sidebar Pencatat
    case 'setor_sampah':
    case 'setoran': 
        // Izinkan Admin DAN Pencatat
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Pencatat')) {
            require_once 'app/controllers/PencatatController.php';
            $controller = new PencatatController();
            $controller->setorSampah();
        } else {
            header("Location: index.php?page=login");
            exit;
        }
        break;

    case 'proses_setor':
        if (isset($_SESSION['role'])) {
            require_once 'app/controllers/PencatatController.php';
            $controller = new PencatatController();
            $controller->prosesSetor();
        }
        break;

    // --- MODUL NASABAH (RIWAYAT) ---
    case 'riwayat':
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Nasabah') {
            require_once 'app/controllers/NasabahController.php';
            (new NasabahController())->riwayatTransaksi(); // Panggil fungsi riwayat
        } else {
            header("Location: index.php?page=login");
        }
        break;

    // --- MODUL PENARIKAN (ADMIN/BENDAHARA) ---
    case 'tarik_saldo':
        require_once 'app/controllers/AdminController.php'; // Atau Controller lain
        (new AdminController())->tarikSaldo();
        break;

    case 'proses_penarikan':
        // Tambahkan Bendahara di sini
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Bendahara')) {
            require_once 'app/controllers/AdminController.php';
            (new AdminController())->prosesPenarikan();
        }
        break;

    // --- MODUL PENJUALAN (ADMIN) ---
    case 'jual_sampah':
        require_once 'app/controllers/AdminController.php';
        (new AdminController())->jualSampah();
        break;

    case 'proses_jual':
        // Tambahkan Bendahara di sini
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Bendahara')) {
            require_once 'app/controllers/AdminController.php';
            (new AdminController())->prosesJual();
        }
        break;
    
    // --- MODUL BENDAHARA ---

    // 1. Penjualan Pusat (Sama dengan Jual Sampah)
    case 'penjualan':
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Bendahara')) {
            require_once 'app/controllers/AdminController.php';
            (new AdminController())->jualSampah(); 
        } else {
            header("Location: index.php?page=login");
        }
        break;

    // 2. Validasi Penarikan (Sama dengan Tarik Saldo)
    // Di sini Bendahara melakukan eksekusi/pencatatan penarikan uang
    // --- BENDAHARA: HALAMAN VALIDASI ---
    case 'validasi':
        // Pastikan hanya Bendahara (atau Admin) yang bisa akses
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Bendahara' || $_SESSION['role'] == 'Admin')) {
            
            // PERBAIKAN: Panggil BendaharaController -> validasiPenarikan
            // (Bukan AdminController -> tarikSaldo lagi)
            require_once 'app/controllers/BendaharaController.php';
            $controller = new BendaharaController();
            $controller->validasiPenarikan();
            
        } else {
            header("Location: index.php?page=login");
        }
        break;
        
    // --- NASABAH: REQUEST TARIK ---
    case 'tarik_saldo_nasabah': // Tampilan Form
        if ($_SESSION['role'] == 'Nasabah') {
            require_once 'app/controllers/NasabahController.php';
            (new NasabahController())->tarikSaldo();
        }
        break;
        
    case 'proses_tarik_nasabah': // Proses Submit
        if ($_SESSION['role'] == 'Nasabah') {
            require_once 'app/controllers/NasabahController.php';
            (new NasabahController())->prosesTarik();
        }
        break;

    // --- BENDAHARA: VALIDASI ---
    case 'proses_validasi': // Eksekusi Terima/Tolak
        if ($_SESSION['role'] == 'Bendahara' || $_SESSION['role'] == 'Admin') {
            require_once 'app/controllers/BendaharaController.php';
            (new BendaharaController())->prosesValidasi();
        }
        break;

    
    // Proses Login (Auth)
    case 'auth_process':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Pastikan file model ada sebelum dipanggil
            if (file_exists('app/models/UserModel.php') && file_exists('app/models/NasabahModel.php')) {
                require_once 'app/models/UserModel.php';
                require_once 'app/models/NasabahModel.php';
            } else {
                die("Error: File Model tidak ditemukan. Cek struktur folder app/models/");
            }
            
            $userModel = new UserModel();
            $nasabahModel = new NasabahModel();
            
            $username = $_POST['username'];
            $password = $_POST['password']; // Password inputan user

            // Cari user berdasarkan username
            // (Pastikan fungsi getByUsername SUDAH ADA di UserModel.php)
            $user = $userModel->getByUsername($username);

            // Verifikasi Password
            if ($user && password_verify($password, $user['password'])) {
                
                // Login Berhasil: Simpan data ke Session
                $_SESSION['id_user'] = $user['id_pengguna'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];

                // Khusus Role Nasabah: Ambil ID Nasabah juga
                if ($user['role'] == 'Nasabah') {
                     $dataNasabah = $nasabahModel->getById($user['id_pengguna']);
                     if ($dataNasabah) {
                         $_SESSION['id_nasabah'] = $dataNasabah['id_nasabah'];
                     }
                }

                // Redirect ke Dashboard
                header("Location: index.php?page=dashboard");
                exit();

            } else {
                // Login Gagal (Password salah atau User tidak ada)
                echo "<script>
                        alert('Username atau Password salah!');
                        window.location.href='index.php?page=login';
                      </script>";
            }
        } else {
            // Jika akses langsung ke url auth_process tanpa POST
            header("Location: index.php?page=login");
            exit();
        }
        break;

    // --- FITUR LOGOUT ---
    case 'logout':
        // Hapus semua session
        session_start();
        session_unset();
        session_destroy();
        
        // Arahkan kembali ke halaman login
        header("Location: index.php?page=login");
        exit;
        break;

    // Route Default
    default:
        require_once 'app/views/auth/login.php';
        break;
}

ob_end_flush(); // Akhiri buffering
?>