<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color: #1a7a3e;">Laporan Keuangan</h4>
            <p class="text-muted small m-0">Laporan kas BSU Kema Pertika termasuk margin keuntungan.</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: 150px;">
                <option>Desember 2025</option>
                <option>November 2025</option>
            </select>
            <button class="btn btn-warning text-white btn-sm fw-bold">
                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex flex-column">
                    <div class="mb-2 text-primary"><i class="bi bi-file-earmark-text fs-4"></i></div>
                    <small class="text-muted fw-bold">Total Setoran</small>
                    <h5 class="fw-bold text-primary mt-1">Rp <?= number_format($data['keuangan']['total_setoran'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex flex-column">
                    <div class="mb-2 text-warning"><i class="bi bi-graph-up-arrow fs-4"></i></div>
                    <small class="text-muted fw-bold">Total Penjualan</small>
                    <h5 class="fw-bold text-warning mt-1">Rp <?= number_format($data['keuangan']['total_penjualan'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex flex-column">
                    <div class="mb-2 text-success"><i class="bi bi-cash-coin fs-4"></i></div>
                    <small class="text-muted fw-bold">Margin Keuntungan</small>
                    <h5 class="fw-bold text-success mt-1">Rp <?= number_format($data['keuangan']['margin_keuntungan'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex flex-column">
                    <div class="mb-2 text-danger"><i class="bi bi-arrow-down-circle fs-4"></i></div>
                    <small class="text-muted fw-bold">Total Penarikan</small>
                    <h5 class="fw-bold text-danger mt-1">Rp <?= number_format($data['keuangan']['total_penarikan'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100 bg-success-subtle">
                <div class="d-flex flex-column">
                    <div class="mb-2 text-success"><i class="bi bi-wallet2 fs-4"></i></div>
                    <small class="text-success fw-bold">Saldo Kas BSU</small>
                    <h5 class="fw-bold text-success mt-1">Rp <?= number_format($data['keuangan']['saldo_bsu'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-warning border-0 small text-dark mb-4">
        <strong>Perhitungan Margin:</strong> Margin Keuntungan = Total Penjualan (Harga Pusat) - Total Setoran (Harga Nasabah).
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold m-0 text-success">Detail Transaksi Terbaru</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Debit (Masuk)</th>
                            <th>Kredit (Keluar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['riwayat']) && $data['riwayat']->num_rows > 0): ?>
                            <?php foreach($data['riwayat'] as $r): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                <td>
                                    <?php if($r['jenis'] == 'Setoran'): ?>
                                        <span class="badge bg-primary-subtle text-primary">Setoran</span>
                                    <?php elseif($r['jenis'] == 'Penjualan'): ?>
                                        <span class="badge bg-warning-subtle text-warning">Penjualan</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger">Penarikan</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $r['keterangan'] ?></td>
                                <td class="text-success fw-bold">
                                    <?= $r['debit'] > 0 ? 'Rp '.number_format($r['debit'],0,',','.') : '-' ?>
                                </td>
                                <td class="text-danger fw-bold">
                                    <?= $r['kredit'] > 0 ? 'Rp '.number_format($r['kredit'],0,',','.') : '-' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>