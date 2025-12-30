<?php require_once 'app/views/layouts/sidebar.php'; ?>
<div class="main-content">
    <h4 class="fw-bold mb-4">Ajukan Penarikan Saldo</h4>
    
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="alert alert-info">
                Saldo Anda saat ini: <strong>Rp <?= number_format($data['saldo_aktif']) ?></strong>
            </div>

            <form action="index.php?page=proses_tarik_nasabah" method="POST">
                <input type="hidden" name="saldo_max" value="<?= $data['saldo_aktif'] ?>">
                
                <div class="mb-3">
                    <label>Nominal Penarikan (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" required min="1000" max="<?= $data['saldo_aktif'] ?>">
                </div>

                <button type="submit" class="btn btn-success w-100">Ajukan Sekarang</button>
            </form>
        </div>
    </div>
</div>