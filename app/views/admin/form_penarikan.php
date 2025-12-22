<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h4 class="fw-bold text-danger">Penarikan Saldo Nasabah</h4>
        <p class="text-muted small m-0">Pencairan dana tabungan nasabah.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="index.php?page=proses_penarikan" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Nasabah</label>
                            <select name="id_nasabah" class="form-select" onchange="window.location='index.php?page=tarik_saldo&id='+this.value">
                                <option value="" disabled <?= !isset($_GET['id']) ? 'selected' : '' ?>>-- Cari Nasabah --</option>
                                <?php foreach($data['nasabah'] as $n): ?>
                                    <option value="<?= $n['id_nasabah'] ?>" <?= (isset($_GET['id']) && $_GET['id'] == $n['id_nasabah']) ? 'selected' : '' ?>>
                                        <?= $n['nama_lengkap'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <?php if(isset($data['saldo_saat_ini'])): ?>
                        <div class="alert alert-info border-0 d-flex justify-content-between align-items-center mb-3">
                            <span>Sisa Saldo:</span>
                            <h4 class="fw-bold m-0">Rp <?= number_format($data['saldo_saat_ini'], 0, ',', '.') ?></h4>
                        </div>
                        <input type="hidden" name="saldo_max" value="<?= $data['saldo_saat_ini'] ?>">
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nominal Penarikan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">Rp</span>
                                <input type="number" name="jumlah_penarikan" class="form-control form-control-lg" placeholder="0" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
                            <i class="bi bi-cash-coin me-2"></i> Cairkan Dana
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>