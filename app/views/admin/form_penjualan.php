<?php require_once 'app/views/layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h4 class="fw-bold text-warning">Penjualan Sampah ke Pengepul</h4>
        <p class="text-muted small m-0">Catat pendapatan BSU dari penjualan sampah daur ulang.</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="index.php?page=proses_jual" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Mitra / Pengepul</label>
                            <input type="text" name="tujuan_pengepul" class="form-control" placeholder="Contoh: UD. Maju Jaya Plastik" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Sampah</label>
                                <select id="id_sampah" name="id_sampah" class="form-select" required onchange="updateTotal()">
                                    <option value="" data-harga="0" selected disabled>-- Pilih Jenis --</option>
                                    <?php foreach($data['sampah'] as $s): 
                                        // Gunakan logika 'isset' agar tidak error warning
                                        $id = isset($s['id_sampah']) ? $s['id_sampah'] : $s['id'];
                                        $nama = isset($s['nama_sampah']) ? $s['nama_sampah'] : 'Sampah';
                                        // Ambil Harga Jual (bukan harga beli nasabah)
                                        $hargaJual = isset($s['harga_jual_pusat']) ? $s['harga_jual_pusat'] : 0;
                                    ?>
                                    <option value="<?= $id ?>" data-harga="<?= $hargaJual ?>">
                                        <?= $nama ?> (Jual: Rp <?= number_format($hargaJual) ?>/kg)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga Jual / Kg</label>
                                <input type="number" id="harga_per_kg" name="harga_per_kg" class="form-control" value="0" required oninput="updateTotal()">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Berat Total (Kg)</label>
                            <input type="number" step="0.01" id="berat" name="berat" class="form-control form-control-lg" placeholder="0.0" required oninput="updateTotal()">
                        </div>

                        <div class="alert alert-warning border-0 d-flex justify-content-between align-items-center">
                            <span>Total Pendapatan Masuk Kas:</span>
                            <h3 class="fw-bold m-0 text-warning" id="tampilan_total">Rp 0</h3>
                        </div>
                        <input type="hidden" name="total_pendapatan" id="input_total">

                        <button type="submit" class="btn btn-warning text-white w-100 fw-bold py-3 mt-2">
                            <i class="bi bi-truck me-2"></i> Proses Penjualan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update harga input saat jenis sampah dipilih
    document.getElementById('id_sampah').addEventListener('change', function() {
        let harga = this.options[this.selectedIndex].getAttribute('data-harga');
        document.getElementById('harga_per_kg').value = harga;
        updateTotal();
    });

    function updateTotal() {
        let harga = document.getElementById('harga_per_kg').value || 0;
        let berat = document.getElementById('berat').value || 0;
        let total = parseFloat(harga) * parseFloat(berat);
        
        document.getElementById('input_total').value = total;
        document.getElementById('tampilan_total').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
    }
</script>