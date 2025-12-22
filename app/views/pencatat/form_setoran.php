<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h4 class="fw-bold" style="color: #1a7a3e;">Transaksi Setor Sampah</h4>
        <p class="text-muted small m-0">Input penimbangan sampah dari nasabah.</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="index.php?page=proses_setor" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Nasabah</label>
                            <select name="id_nasabah" class="form-select form-select-lg bg-light" required>
                                <option value="" selected disabled>-- Cari Nama Nasabah --</option>
                                <?php foreach($data['nasabah'] as $n): ?>
                                    <option value="<?= $n['id_nasabah'] ?>">
                                        <?= $n['nama_lengkap'] ?> (ID: <?= str_pad($n['id_nasabah'], 3, '0', STR_PAD_LEFT) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Sampah</label>
                                <select id="jenis_sampah" name="id_sampah" class="form-select" required onchange="updateHarga()">
                                    <option value="" data-harga="0" selected disabled>-- Pilih Jenis --</option>
                                    
                                    <?php foreach($data['sampah'] as $s): 
                                        // 1. Deteksi ID Sampah (Cari 'id_sampah', kalau tidak ada cari 'id')
                                        $id_fix = '';
                                        if (isset($s['id_sampah'])) { $id_fix = $s['id_sampah']; }
                                        elseif (isset($s['id'])) { $id_fix = $s['id']; }
                                        
                                        // 2. Deteksi Harga (Cari 'harga_beli_per_kg', default ke 0)
                                        $harga_fix = isset($s['harga_beli_per_kg']) ? $s['harga_beli_per_kg'] : 0;
                                        
                                        // 3. Deteksi Nama
                                        $nama_fix = isset($s['nama_sampah']) ? $s['nama_sampah'] : 'Tanpa Nama';
                                    ?>
                                    
                                    <option value="<?= $id_fix ?>" data-harga="<?= $harga_fix ?>">
                                        <?= $nama_fix ?> (Rp <?= number_format($harga_fix, 0, ',', '.') ?>/kg)
                                    </option>
                                    
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Berat (Kg)</label>
                                <input type="number" step="0.01" id="berat" name="berat" class="form-control" 
                                       placeholder="0.0" required oninput="hitungTotal()">
                            </div>
                        </div>

                        <div class="alert alert-success border-0 d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="d-block text-success-emphasis">Estimasi Pendapatan Nasabah</small>
                                <h3 class="fw-bold m-0" id="tampilan_total">Rp 0</h3>
                            </div>
                            <i class="bi bi-wallet2 fs-1 text-success opacity-50"></i>
                        </div>
                        
                        <input type="hidden" name="total_harga" id="total_harga_input">

                        <button type="submit" class="btn btn-success w-100 fw-bold py-3 mt-3 shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Petunjuk</h5>
                    <ul class="small ps-3 mb-0" style="opacity: 0.9;">
                        <li class="mb-2">Pastikan nasabah sudah terdaftar.</li>
                        <li class="mb-2">Pilih jenis sampah yang sesuai fisik.</li>
                        <li class="mb-2">Gunakan titik (.) untuk berat desimal, misal: <strong>1.5</strong> kg.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateHarga() {
    hitungTotal();
}

function hitungTotal() {
    let selectSampah = document.getElementById('jenis_sampah');
    let hargaPerKg = selectSampah.options[selectSampah.selectedIndex].getAttribute('data-harga');
    let berat = document.getElementById('berat').value;
    
    // Pastikan nilai valid
    if(hargaPerKg && berat) {
        let total = parseFloat(hargaPerKg) * parseFloat(berat);
        
        // Format Rupiah
        let rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
        
        document.getElementById('tampilan_total').innerText = rupiah;
        document.getElementById('total_harga_input').value = total;
    } else {
        document.getElementById('tampilan_total').innerText = "Rp 0";
        document.getElementById('total_harga_input').value = 0;
    }
}
</script>