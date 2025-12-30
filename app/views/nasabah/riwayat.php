<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color: #1a7a3e;">Riwayat Transaksi</h4>
            <p class="text-muted small m-0">Halo, <strong><?= $_SESSION['nama_lengkap'] ?></strong>! Berikut mutasi saldo Anda.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-3 shadow-sm border border-success">
            <small class="text-muted d-block">Saldo Tabungan</small>
            <h4 class="fw-bold text-success m-0">Rp <?= number_format($data['saldo'], 0, ',', '.') ?></h4>
        </div>
    </div>

    <div class="mb-3 text-end">
        <a href="index.php?page=tarik_saldo_nasabah" class="btn btn-warning btn-sm fw-bold">
            <i class="bi bi-wallet2 me-1"></i> Ajukan Penarikan
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Aktivitas</th>
                            <th class="text-success">Uang Masuk</th>
                            <th class="text-danger">Uang Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data['riwayat'] && $data['riwayat']->num_rows > 0): ?>
                            <?php foreach($data['riwayat'] as $r): ?>
                            <tr>
                                <td class="ps-4"><?= date('d M Y, H:i', strtotime($r['tanggal'])) ?></td>
                                <td>
                                    <?php if($r['jenis'] == 'Setor Sampah'): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 p-2 rounded-circle me-2 text-success">
                                                <i class="bi bi-recycle"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block text-dark">Setor Sampah</span>
                                                <small class="text-muted"><?= $r['info_berat'] ?> Kg</small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-2 text-danger">
                                                <i class="bi bi-cash"></i>
                                            </div>
                                            <span class="fw-bold text-dark">Penarikan Tunai</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= $r['masuk'] > 0 ? '+ Rp '.number_format($r['masuk']) : '-' ?>
                                </td>
                                <td class="fw-bold text-danger">
                                    <?= $r['keluar'] > 0 ? '- Rp '.number_format($r['keluar']) : '-' ?>
                                </td>
                                
                                <td>
                                    <?php if($r['jenis'] == 'Setor Sampah'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success">Berhasil</span>
                                    
                                    <?php else: ?>
                                        <?php 
                                            // Ambil status, default 'approved' untuk data lama
                                            $status = isset($r['status']) ? $r['status'] : 'approved'; 
                                        ?>

                                        <?php if($status == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split me-1"></i> Proses
                                            </span>
                                        <?php elseif($status == 'rejected'): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i> Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Diterima
                                            </span>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    Belum ada riwayat transaksi.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>