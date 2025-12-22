<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <a href="index.php?page=data_sampah" class="text-decoration-none text-success small">
            <i class="bi bi-arrow-left"></i> Kembali ke Master Sampah
        </a>
        <h4 class="fw-bold mt-2" style="color: #1a7a3e;">Edit Jenis Sampah</h4>
    </div>

    <div class="card border-0 shadow-sm rounded-4 col-md-6">
        <div class="card-body p-4">
            <form action="index.php?page=proses_edit_sampah" method="POST">
                <input type="hidden" name="kode_sampah" value="<?= $data['s']['kode_sampah'] ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Kode Sampah</label>
                    <input type="text" class="form-control bg-light" value="<?= $data['s']['kode_sampah'] ?>" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Sampah</label>
                    <input type="text" name="nama_sampah" class="form-control" value="<?= $data['s']['nama_sampah'] ?>" required>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Harga Beli</label>
                        <input type="number" name="harga_beli_per_kg" class="form-control" value="<?= $data['s']['harga_beli_per_kg'] ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Harga Jual</label>
                        <input type="number" name="harga_jual_pusat" class="form-control" value="<?= $data['s']['harga_jual_pusat'] ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2">Update Data</button>
            </form>
        </div>
    </div>
</div>