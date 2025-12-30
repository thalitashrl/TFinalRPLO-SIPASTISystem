<?php require_once 'app/views/layouts/sidebar.php'; ?>
<div class="main-content">
    
    <h4 class="fw-bold mb-3 text-primary">
        <i class="bi bi-hourglass-split me-2"></i>Permintaan Baru
    </h4>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Tanggal Request</th>
                            <th>Nasabah</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data['request'] && $data['request']->num_rows > 0): ?>
                            <?php foreach($data['request'] as $row): ?>
                            <tr>
                                <td class="ps-4"><?= date('d/m/Y H:i', strtotime($row['tgl_penarikan'])) ?></td>
                                <td class="fw-bold"><?= $row['nama_lengkap'] ?></td>
                                <td class="text-danger fw-bold">Rp <?= number_format($row['jumlah_penarikan']) ?></td>
                                <td>
                                    <a href="index.php?page=proses_validasi&id=<?= $row['id_penarikan'] ?>&aksi=approve" 
                                       class="btn btn-sm btn-success me-1 shadow-sm"
                                       onclick="return confirm('Yakin setujui pencairan dana ini?')">
                                       <i class="bi bi-check-lg"></i> Terima
                                    </a>
                                    
                                    <a href="index.php?page=proses_validasi&id=<?= $row['id_penarikan'] ?>&aksi=reject" 
                                       class="btn btn-sm btn-danger shadow-sm"
                                       onclick="return confirm('Tolak permintaan ini?')">
                                       <i class="bi bi-x-lg"></i> Tolak
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted fst-italic">
                                    Tidak ada permintaan baru saat ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr class="my-5 border-secondary opacity-25">

    <h4 class="fw-bold mb-3 text-secondary">
        <i class="bi bi-clock-history me-2"></i>Riwayat Proses Validasi
    </h4>
    
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-secondary bg-opacity-10 text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Nasabah</th>
                            <th>Nominal</th>
                            <th>Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data['riwayat'] && $data['riwayat']->num_rows > 0): ?>
                            <?php foreach($data['riwayat'] as $log): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= date('d M Y, H:i', strtotime($log['tgl_penarikan'])) ?></td>
                                <td><?= $log['nama_lengkap'] ?></td>
                                <td class="text-secondary">Rp <?= number_format($log['jumlah_penarikan']) ?></td>
                                <td>
                                    <?php if($log['status'] == 'approved'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i> Diterima
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    Belum ada data riwayat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>