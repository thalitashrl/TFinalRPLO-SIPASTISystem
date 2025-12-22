<?php require_once 'app/views/layouts/sidebar.php'; ?>

<style>
    .table-custom th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
    }
    .badge-role {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 12px;
    }
    .role-Admin { background: #e0e7ff; color: #4338ca; }
    .role-Pencatat { background: #d1fae5; color: #047857; }
    .role-Bendahara { background: #ffedd5; color: #c2410c; }
    .role-Nasabah { background: #f3f4f6; color: #374151; }
</style>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color: #1a7a3e;">Kelola Pengguna</h4>
            <p class="text-muted small m-0">Manajemen akun staf dan nasabah.</p>
        </div>
        <button class="btn btn-warning text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-plus-lg me-2"></i> Tambah Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Role</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
    // Pastikan data tersedia
    if (isset($data['pengguna']) && (is_array($data['pengguna']) || is_object($data['pengguna']))): 
        $no = 1;
        foreach($data['pengguna'] as $u): 
            // 1. Ambil ID Pengguna Login (Cek berbagai kemungkinan nama session)
            $current_user_id = 0;
            if (isset($_SESSION['user_id'])) { $current_user_id = $_SESSION['user_id']; }
            elseif (isset($_SESSION['id_pengguna'])) { $current_user_id = $_SESSION['id_pengguna']; }
    ?>
    <tr>
        <td class="ps-4 fw-bold text-muted"><?= $no++ ?></td>
        <td>
            <div class="fw-bold text-dark"><?= isset($u['nama_lengkap']) ? $u['nama_lengkap'] : '-' ?></div>
            <small class="text-muted"><?= isset($u['username']) ? $u['username'] : '-' ?></small>
        </td>
        <td>
            <?php 
            // Badge warna-warni sesuai Role
            $role = isset($u['role']) ? $u['role'] : 'Staf';
            $badgeColor = 'bg-secondary';
            if($role == 'Admin') $badgeColor = 'bg-primary';
            if($role == 'Pencatat') $badgeColor = 'bg-info text-dark';
            if($role == 'Bendahara') $badgeColor = 'bg-warning text-dark';
            ?>
            <span class="badge <?= $badgeColor ?> fw-normal px-3 py-2"><?= $role ?></span>
        </td>
        <td class="text-end pe-4">
            <div class="btn-group shadow-sm">
                <a href="index.php?page=edit_pengguna&id=<?= $u['id_pengguna'] ?>" 
                   class="btn btn-sm btn-light text-primary me-1" title="Edit Data">
                    <i class="bi bi-pencil-square"></i>
                </a>
                
                <?php if($u['id_pengguna'] != $current_user_id): ?>
                    <a href="index.php?page=hapus_pengguna&id=<?= $u['id_pengguna'] ?>" 
                       class="btn btn-sm btn-light text-danger" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" 
                       title="Hapus Pengguna">
                        <i class="bi bi-trash"></i>
                    </a>
                <?php else: ?>
                    <button class="btn btn-sm btn-light text-muted" disabled title="Sedang Login">
                        <i class="bi bi-lock-fill"></i>
                    </button>
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="4" class="text-center py-5 text-muted">Belum ada data pengguna staf.</td>
    </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=proses_tambah_user" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role Akun</label>
                        <select name="role" id="roleSelect" class="form-select" onchange="toggleFormNasabah()" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Pencatat">Pencatat</option>
                            <option value="Bendahara">Bendahara</option>
                            <option value="Nasabah">Nasabah</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div id="formNasabah" style="display: none;" class="bg-light p-3 rounded border">
                        <h6 class="fw-bold text-success mb-3" style="font-size: 13px;">DETAIL NASABAH</h6>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">No. Telepon</label>
                            <input type="number" name="no_telepon" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFormNasabah() {
        var role = document.getElementById("roleSelect").value;
        var form = document.getElementById("formNasabah");
        var inputs = form.querySelectorAll("input, textarea");

        if (role === "Nasabah") {
            form.style.display = "block";
            inputs.forEach(input => input.required = true);
        } else {
            form.style.display = "none";
            inputs.forEach(input => input.required = false);
        }
    }
</script>