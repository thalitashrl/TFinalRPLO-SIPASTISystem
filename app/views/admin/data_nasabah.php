<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color: #1a7a3e;">Data Nasabah</h4>
            <p class="text-muted small m-0">Daftar warga yang terdaftar sebagai anggota BSU Kema Pertika.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-warning text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahNasabah">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah Nasabah
            </button>
            <form action="index.php" method="GET" class="d-flex gap-2">
    <input type="hidden" name="page" value="data_nasabah">
    <div class="input-group input-group-sm" style="width: 250px;">
        <input type="text" name="search" class="form-control" placeholder="Cari nama nasabah..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <button type="submit" class="btn btn-success px-3"><i class="bi bi-search"></i></button>
    </div>
</form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Nama Nasabah</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">No. Telp</th>
                            <th class="py-3 text-center">Saldo Tabungan</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (isset($data['nasabah']) && $data['nasabah']->num_rows > 0):
                            foreach($data['nasabah'] as $n): 
                        ?>
                        <tr>
                            <td class="ps-4 text-muted fw-bold"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= $n['nama_lengkap'] ?></div>
                                <small class="text-muted">ID: NSB-<?= str_pad($n['id_nasabah'], 3, '0', STR_PAD_LEFT) ?></small>
                            </td>
                            <td class="small text-muted" style="max-width: 200px;"><?= $n['alamat'] ?></td>
                            <td><span class="badge bg-light text-dark border fw-normal"><?= $n['no_telepon'] ?></span></td>
                            <td class="fw-bold text-success text-center">Rp <?= number_format($n['saldo_akhir'], 0, ',', '.') ?></td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-light text-success me-1" title="Lihat Riwayat">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="index.php?page=edit_nasabah&id=<?= $n['id_nasabah'] ?>" class="btn btn-sm btn-light text-primary me-1" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="index.php?page=hapus_nasabah&id=<?= $n['id_nasabah'] ?>" 
                                       class="btn btn-sm btn-light text-danger" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus nasabah ini? Tindakan ini tidak dapat dibatalkan.')" 
                                       title="Hapus Nasabah">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data nasabah yang terdaftar.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahNasabah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: #1a7a3e;">
                <h5 class="modal-title fw-bold">Tambah Nasabah Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=proses_tambah_user" method="POST">
                <input type="hidden" name="role" value="Nasabah">
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">No. Telepon</label>
                        <input type="number" name="no_telepon" class="form-control" placeholder="Contoh: 081234567890" required>
                    </div>
                    <hr class="my-4 text-muted">
                    <h6 class="fw-bold mb-3" style="font-size: 13px; color: #1a7a3e;">AKUN LOGIN NASABAH</h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username login" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password login" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">Simpan Nasabah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahNasabah'));
        // Jika ingin tes manual: myModal.show();
    });
</script>