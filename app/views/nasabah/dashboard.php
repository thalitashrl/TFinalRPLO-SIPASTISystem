<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h3 class="fw-bold text-success">
            Selamat Datang, <?= $_SESSION['nama_lengkap'] ?>! 👋
        </h3>
        <p class="text-muted">Berikut adalah ringkasan tabungan sampah Anda.</p>
    </div>

    <div class="card border-0 shadow rounded-4 bg-success text-white mb-4 overflow-hidden position-relative" style="background-color: #1a7a3e !important;">
        <div class="card-body p-5 position-relative z-1">
            <small class="opacity-75 text-uppercase fw-bold ls-1">Saldo Tabungan Saat Ini</small>
            <h1 class="display-4 fw-bold mt-2 mb-0">
                Rp <?= number_format($data['stats']['saldo'], 0, ',', '.') ?>
            </h1>
        </div>
        <i class="bi bi-wallet2 position-absolute top-50 end-0 translate-middle-y me-4" style="font-size: 10rem; opacity: 0.15;"></i>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                        <i class="bi bi-recycle fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Sampah Disetor</small>
                        <h3 class="fw-bold mb-0 text-dark">
                            <?= number_format($data['stats']['total_berat'], 1) ?> <span class="fs-6 text-muted">Kg</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3 text-danger">
                        <i class="bi bi-cash-stack fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Uang Ditarik</small>
                        <h3 class="fw-bold mb-0 text-dark">
                            Rp <?= number_format($data['stats']['total_tarik'], 0, ',', '.') ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php?page=riwayat" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold">
            <i class="bi bi-clock-history me-2"></i> Lihat Riwayat Lengkap
        </a>
    </div>
</div>