<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-5">
        <h3 class="fw-bold">Halo, Petugas Pencatat! 👋</h3>
        <p class="text-muted">Siap melayani nasabah hari ini?</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="index.php?page=setor_sampah" class="card border-0 shadow-sm text-decoration-none bg-success text-white h-100 hover-scale">
                <div class="card-body p-5 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">Setor Sampah</h2>
                        <span class="opacity-75">Input penimbangan sampah nasabah</span>
                    </div>
                    <i class="bi bi-basket-fill display-1 opacity-25"></i>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-success mb-3">Panduan Singkat</h5>
                    <ul class="text-muted small mb-0">
                        <li class="mb-2">Pastikan Nasabah sudah terdaftar sebelum transaksi.</li>
                        <li class="mb-2">Pilih jenis sampah dengan teliti agar harga sesuai.</li>
                        <li class="mb-2">Gunakan titik (.) untuk berat desimal (contoh: 1.5 Kg).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.02); }
</style>