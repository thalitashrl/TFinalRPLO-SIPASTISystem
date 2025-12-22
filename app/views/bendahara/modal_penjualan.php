<div class="modal fade" id="modalJualPusat" tabindex="-1">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content">
            <div class="modal-header bg-umi-green text-white">
                <h5 class="modal-title">Catat Penjualan ke Pusat</h5> [cite: 662]
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=proses_jual" method="POST">
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Pembeli (Pusat Pengepul)</label> [cite: 662]
                            <input type="text" name="pembeli" class="form-control" value="Pusat Pengepul Regional Makassar" readonly> [cite: 663]
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tanggal</label> [cite: 664]
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded mb-3">
                        <h6 class="fw-bold mb-3">Detail Sampah yang Dijual</h6> [cite: 666]
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select name="kode_sampah" id="jualSampah" class="form-select border-umi-green" required>
                                    <option value="" data-hb="1500" data-hj="1800">Plastik PET</option> [cite: 670, 683]
                                    <option value="" data-hb="1200" data-hj="1500">Kardus</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" id="beratJual" class="form-control" placeholder="Berat (kg)" required> [cite: 667]
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text small">HB: 1500</span> [cite: 668]
                                    <span class="input-group-text small bg-white text-success fw-bold">HJ: 1800</span> [cite: 670]
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center border rounded py-3 bg-white shadow-sm">
                        <div class="col-6 border-end">
                            <p class="text-muted small mb-0">Total Penjualan</p> [cite: 671]
                            <h4 class="fw-bold" id="totalJualText">Rp 0</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-0 text-success">Margin Keuntungan BSU</p> [cite: 689]
                            <h4 class="fw-bold text-success" id="marginBSUText">Rp 0</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button> [cite: 694]
                    <button type="submit" class="btn btn-umi-green px-4">Simpan Penjualan</button> [cite: 710]
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('beratJual').addEventListener('input', function() {
        const select = document.getElementById('jualSampah');
        const hb = parseFloat(select.options[select.selectedIndex].getAttribute('data-hb'));
        const hj = parseFloat(select.options[select.selectedIndex].getAttribute('data-hj'));
        const berat = parseFloat(this.value) || 0;

        const totalJual = hj * berat;
        const margin = (hj - hb) * berat;

        document.getElementById('totalJualText').innerText = 'Rp ' + totalJual.toLocaleString('id-ID');
        document.getElementById('marginBSUText').innerText = 'Rp ' + margin.toLocaleString('id-ID');
    });
</script>