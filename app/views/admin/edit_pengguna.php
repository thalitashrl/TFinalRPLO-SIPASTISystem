<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <a href="index.php?page=kelola_pengguna" class="text-decoration-none text-success small">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelola Pengguna
        </a>
        <h4 class="fw-bold mt-2" style="color: #1a7a3e;">Edit Data Staf</h4>
    </div>

    <div class="card border-0 shadow-sm rounded-4 col-md-6">
        <div class="card-body p-4">
            <form action="index.php?page=proses_edit_pengguna" method="POST">
                <input type="hidden" name="id_pengguna" value="<?= $data['u']['id_pengguna'] ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['u']['nama_lengkap'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $data['u']['username'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Role / Jabatan</label>
                    <select name="role" class="form-select">
                        <option value="Admin" <?= $data['u']['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="Pencatat" <?= $data['u']['role'] == 'Pencatat' ? 'selected' : '' ?>>Pencatat (Petugas Timbang)</option>
                        <option value="Bendahara" <?= $data['u']['role'] == 'Bendahara' ? 'selected' : '' ?>>Bendahara</option>
                    </select>
                </div>

                <hr>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Ubah Password (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>