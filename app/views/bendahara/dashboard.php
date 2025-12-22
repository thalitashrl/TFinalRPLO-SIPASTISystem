<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h3 class="fw-bold">Selamat Datang, Bendahara! 💰</h3>
        <p class="text-muted">Kelola arus kas dan validasi penarikan nasabah di sini.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark h-100">
                <div class="card-body p-4">
                    <h6 class="opacity-75 mb-2 fw-bold">Saldo Kas BSU</h6>
                    <h2 class="fw-bold mb-0">
                        <?php 
                        // Jika variabel stats belum ada, kita handle manual atau biarkan 0 dulu
                        echo isset($data['stats']['kas']) ? "Rp " . number_format($data['stats']['kas'],0,',','.') : "Lihat Laporan"; 
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="row h-100">
                <div class="col-md-6">
                    <a href="index.php?page=validasi" class="card border-0 shadow-sm h-100 text-decoration-none hover-card">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3 text-danger">
                                <i class="bi bi-wallet2 fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Validasi Penarikan</h5>
                                <small class="text-muted">Cairkan dana nasabah</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="index.php?page=penjualan" class="card border-0 shadow-sm h-100 text-decoration-none hover-card">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                                <i class="bi bi-shop fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Penjualan Pusat</h5>
                                <small class="text-muted">Jual sampah ke pengepul</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-3px); }
</style>