<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <a href="index.php?page=data_nasabah" class="text-decoration-none text-success small">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Nasabah
        </a>
        <h4 class="fw-bold mt-2" style="color: #1a7a3e;">Edit Profil Nasabah</h4>
    </div>

    <div class="card border-0 shadow-sm rounded-4 col-lg-6">
        <div class="card-body p-4">
            <form action="index.php?page=proses_edit_nasabah" method="POST">
                <input type="hidden" name="id_nasabah" value="<?= $data['n']['id_nasabah'] ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control shadow-sm" 
                           value="<?= $data['n']['nama_lengkap'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nomor Telepon/WA</label>
                    <input type="number" name="no_telepon" class="form-control shadow-sm" 
                           value="<?= $data['n']['no_telepon'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control shadow-sm" rows="3" required><?= $data['n']['alamat'] ?></textarea>
                </div>

                <div class="bg-light p-3 rounded-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Saldo Tabungan Saat Ini</span>
                        <span class="fw-bold text-success">Rp <?= number_format($data['n']['saldo_akhir'], 0, ',', '.') ?></span>
                    </div>
                    <small class="text-muted" style="font-size: 11px;">*Saldo hanya dapat berubah melalui transaksi setoran atau penarikan.</small>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>