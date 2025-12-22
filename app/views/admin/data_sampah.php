<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color: #1a7a3e;">Master Data Sampah</h4>
            <p class="text-muted small m-0">Atur harga beli dan harga jual untuk 8 jenis sampah utama.</p>
        </div>
        <button class="btn btn-warning text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSampah">
            <i class="bi bi-plus-lg me-2"></i> Tambah Jenis
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Kode</th>
                            <th class="py-3">Jenis Sampah</th>
                            <th class="py-3">Harga Beli (Nasabah)</th>
                            <th class="py-3">Harga Jual (Pusat)</th>
                            <th class="py-3">Margin BSU</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['sampah']) && (is_array($data['sampah']) || is_object($data['sampah']))): ?>
                            <?php foreach($data['sampah'] as $s): 
                                // 1. Logika Deteksi ID Otomatis (Prioritaskan id_sampah, fallback ke id)
                                $id_sampah = '';
                                if (isset($s['id_sampah'])) { $id_sampah = $s['id_sampah']; }
                                elseif (isset($s['id'])) { $id_sampah = $s['id']; }
                                
                                // 2. Ambil Data Harga dengan Aman
                                $beli = isset($s['harga_beli_per_kg']) ? $s['harga_beli_per_kg'] : 0;
                                $jual = isset($s['harga_jual_pusat']) ? $s['harga_jual_pusat'] : 0;
                                
                                // 3. Hitung Margin
                                $margin = $jual - $beli;
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= isset($s['kode_sampah']) ? $s['kode_sampah'] : '-' ?></td>
                                <td class="fw-bold"><?= isset($s['nama_sampah']) ? $s['nama_sampah'] : '-' ?></td>
                                <td class="text-danger">
                                    Rp <?= number_format($beli, 0, ',', '.') ?>/kg
                                </td>
                                <td class="text-primary">
                                    Rp <?= number_format($jual, 0, ',', '.') ?>/kg
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3">
                                        + Rp <?= number_format($margin, 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="index.php?page=edit_sampah&id=<?= $s['kode_sampah'] ?>" 
                                        class="btn btn-sm btn-light text-primary me-1 shadow-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <a href="index.php?page=hapus_sampah&id=<?= $s['kode_sampah'] ?>" 
                                        class="btn btn-sm btn-light text-danger shadow-sm" 
                                        onclick="return confirm('Hapus sampah kode <?= $s['kode_sampah'] ?>?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data sampah. Silakan tambah data baru.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahSampah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Tambah Jenis Sampah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=proses_tambah_sampah" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Sampah</label>
                        <input type="text" name="nama_sampah" class="form-control" placeholder="Contoh: Plastik Bening" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Harga Beli (/kg)</label>
                            <input type="number" name="harga_beli" class="form-control" placeholder="Harga Nasabah" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Harga Jual (/kg)</label>
                            <input type="number" name="harga_jual" class="form-control" placeholder="Harga Pusat" required>
                        </div>
                    </div>
                    <div class="alert alert-info py-2 mb-0" style="font-size: 12px;">
                        <i class="bi bi-info-circle me-1"></i> Kode sampah akan digenerate otomatis oleh sistem.
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>