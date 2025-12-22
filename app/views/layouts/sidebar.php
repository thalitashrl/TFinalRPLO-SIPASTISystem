<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PASTI | BSU Kema Pertika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles dari Desain Baru */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1a7a3e 0%, #145c2e 100%); /* Hijau Gradasi */
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: #ffc107; /* Kuning Emas */
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #1a7a3e;
        }

        .sidebar-menu { padding: 20px 0; }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .menu-item.active {
            border-left-color: #ffc107;
            background: rgba(255, 255, 255, 0.15);
        }

        .menu-item i { font-size: 18px; width: 20px; }
        .menu-item-text { flex: 1; font-size: 14px; }

        /* Styles untuk Main Content wrapper agar tidak tertutup */
        .main-content {
            margin-left: 260px; /* KUNCI PERBAIKAN LAYOUT */
            padding: 30px;
            min-height: 100vh;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-260px); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>

<script>
    function toggleSubmenu(element) {
        const submenu = element.nextElementSibling;
        const icon = element.querySelector('.bi-chevron-down');
        
        if (submenu.style.display === "none") {
            submenu.style.display = "block";
            icon.style.transform = "rotate(180deg)";
        } else {
            submenu.style.display = "none";
            icon.style.transform = "rotate(0deg)";
        }
    }
</script>

<body>

<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <div class="sidebar-logo">
                <i class="bi bi-recycle"></i>
            </div>
            <div>
                <h6 class="m-0 fw-bold">SI-PASTI</h6>
                <small style="font-size: 11px; opacity: 0.8;">BSU Kema Pertika</small>
            </div>
        </a>
    </div>

    <div class="sidebar-menu">
        <a href="index.php?page=dashboard" class="menu-item <?= (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-fill"></i>
            <span class="menu-item-text">Dashboard</span>
        </a>

        <?php if ($_SESSION['role'] == 'Admin'): ?>
            <div class="px-3 mt-3 mb-2 text-white-50" style="font-size: 11px;">ADMINISTRASI</div>
            
            <div class="menu-item" onclick="toggleSubmenu(this)">
                <i class="bi bi-database-fill"></i>
                <span class="menu-item-text">Master Data</span>
                <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </div>
            <div class="submenu shadow-inset" style="display: none; background: rgba(0,0,0,0.1);">
                <a href="index.php?page=data_sampah" class="menu-item ps-5 py-2" style="font-size: 13px;">
                    <i class="bi bi-recycle"></i> Data Sampah
                </a>
                <a href="index.php?page=data_nasabah" class="menu-item ps-5 py-2" style="font-size: 13px;">
                    <i class="bi bi-people"></i> Data Nasabah
                </a>
            </div>

            <div class="menu-item" onclick="toggleSubmenu(this)">
                <i class="bi bi-cash-stack"></i> 
                <span class="menu-item-text">Transaksi</span>
                <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </div>

            <div class="submenu shadow-inset" style="display: none; background: rgba(0,0,0,0.1);">
                
                <a href="index.php?page=setor_sampah" class="menu-item ps-5 py-2" style="font-size: 13px;">
                    <i class="bi bi-basket"></i> Setor Sampah
                </a>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
                <a href="index.php?page=tarik_saldo" class="menu-item ps-5 py-2" style="font-size: 13px;">
                    <i class="bi bi-wallet2"></i> Tarik Saldo
                </a>
                <?php endif; ?>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
                <a href="index.php?page=jual_sampah" class="menu-item ps-5 py-2" style="font-size: 13px;">
                    <i class="bi bi-truck"></i> Jual Sampah
                </a>
                <?php endif; ?>

            </div>

            <a href="index.php?page=kelola_pengguna" class="menu-item <?= ($_GET['page'] == 'kelola_pengguna') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i>
                <span class="menu-item-text">Kelola Pengguna</span>
            </a>
            <a href="index.php?page=laporan_keuangan" class="menu-item <?= ($_GET['page'] == 'laporan_keuangan') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span class="menu-item-text">Laporan Keuangan</span>
            </a>

        <?php elseif ($_SESSION['role'] == 'Pencatat'): ?>
            <div class="px-3 mt-3 mb-2 text-white-50" style="font-size: 11px;">OPERASIONAL</div>
            <a href="index.php?page=setoran" class="menu-item">
                <i class="bi bi-pencil-square"></i>
                <span class="menu-item-text">Catat Setoran</span>
            </a>
            <a href="index.php?page=laporan_keuangan" class="menu-item <?= ($_GET['page'] == 'laporan_keuangan') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span class="menu-item-text">Laporan Keuangan</span>
            </a>

        <?php elseif ($_SESSION['role'] == 'Bendahara'): ?>
            <div class="px-3 mt-3 mb-2 text-white-50" style="font-size: 11px;">KEUANGAN</div>
            <a href="index.php?page=penjualan" class="menu-item">
                <i class="bi bi-shop"></i>
                <span class="menu-item-text">Penjualan Pusat</span>
            </a>
            <a href="index.php?page=validasi" class="menu-item">
                <i class="bi bi-check-circle-fill"></i>
                <span class="menu-item-text">Validasi Penarikan</span>
            </a>
            <a href="index.php?page=laporan_keuangan" class="menu-item <?= ($_GET['page'] == 'laporan_keuangan') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span class="menu-item-text">Laporan Keuangan</span>
            </a>

        <?php elseif ($_SESSION['role'] == 'Nasabah'): ?>
            <div class="px-3 mt-3 mb-2 text-white-50" style="font-size: 11px;">PERSONAL</div>
            <a href="index.php?page=riwayat" class="menu-item">
                <i class="bi bi-clock-history"></i>
                <span class="menu-item-text">Riwayat Transaksi</span>
            </a>
        <?php endif; ?>

        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
            <a href="index.php?page=logout" class="menu-item text-warning mt-2">
                <i class="bi bi-box-arrow-right"></i>
                <span class="menu-item-text">Logout</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSubmenu(element) {
    // Cari elemen submenu (div tepat setelah tombol yang diklik)
    var submenu = element.nextElementSibling;
    var icon = element.querySelector('.bi-chevron-down');
    
    // Logika Buka/Tutup
    if (submenu.style.display === "none") {
        submenu.style.display = "block";
        if(icon) icon.style.transform = "rotate(180deg)"; // Putar panah ke atas
    } else {
        submenu.style.display = "none";
        if(icon) icon.style.transform = "rotate(0deg)"; // Putar panah kembali
    }
}
</script>
