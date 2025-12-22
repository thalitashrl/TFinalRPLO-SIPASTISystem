<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-5">
        <h3 class="fw-bold">Selamat Datang, Administrator! 👋</h3>
        <p class="text-muted">Berikut adalah ringkasan performa Bank Sampah hari ini.</p>
    </div>

    <div class="row mb-5">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="opacity-75 mb-1">Total Nasabah</h6>
                        <h2 class="fw-bold mb-0"><?= $data['stats']['nasabah'] ?> Orang</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="opacity-75 mb-1">Sampah Terkelola</h6>
                        <h2 class="fw-bold mb-0"><?= number_format($data['stats']['total_sampah'], 1) ?> Kg</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="bi bi-recycle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="opacity-75 mb-1">Total Tabungan Nasabah</h6>
                        <h2 class="fw-bold mb-0">Rp <?= number_format($data['stats']['uang_nasabah'], 0, ',', '.') ?></h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3 text-secondary">Akses Cepat</h5>
    <div class="row">
        <div class="col-md-3">
            <a href="index.php?page=setor_sampah" class="card border-0 shadow-sm text-decoration-none hover-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-basket fs-1 text-success mb-2 d-block"></i>
                    <span class="fw-bold text-dark">Setor Sampah</span>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="index.php?page=tarik_saldo" class="card border-0 shadow-sm text-decoration-none hover-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-cash-coin fs-1 text-danger mb-2 d-block"></i>
                    <span class="fw-bold text-dark">Tarik Saldo</span>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="index.php?page=jual_sampah" class="card border-0 shadow-sm text-decoration-none hover-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-truck fs-1 text-warning mb-2 d-block"></i>
                    <span class="fw-bold text-dark">Jual ke Pengepul</span>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="index.php?page=laporan_keuangan" class="card border-0 shadow-sm text-decoration-none hover-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-file-earmark-bar-graph fs-1 text-primary mb-2 d-block"></i>
                    <span class="fw-bold text-dark">Laporan</span>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); }
</style>