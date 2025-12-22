<head>
    <style>
        .text-umi-green { color: #006b3c; }
        .bg-umi-green { background-color: #006b3c; }
        .text-umi-gold { color: #d4af37; }
        .btn-outline-umi {
            color: #006b3c;
            border-color: #006b3c;
        }
        .btn-outline-umi:hover {
            background-color: #006b3c;
            color: #d4af37;
        }
    </style>
</head>

<div class="modal fade" id="modalSetoran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-umi-green">Catat Setoran Baru</h5> [cite: 391, 430]
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?page=simpan_setoran" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Nasabah</label> [cite: 393, 414, 432, 447]
                        <select name="id_nasabah" class="form-select border-umi-green" required>
                            <option value="">-- Pilih Nasabah --</option> [cite: 394, 436, 449, 474]
                            <option value="1">NSB-001 Budi Santoso</option> [cite: 125, 417]
                            <option value="2">NSB-002 St. Aminah</option> [cite: 418]
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tanggal</label> [cite: 395, 423, 441, 448, 478]
                            <input type="text" class="form-control bg-light" value="<?= date('d/m/Y') ?>" readonly> [cite: 396, 424, 442, 450]
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Jenis Sampah</label> [cite: 348, 397, 438, 452, 477, 480]
                            <select name="kode_sampah" id="selectSampah" class="form-select border-umi-green" required>
                                <option value="">-- Pilih --</option> [cite: 400]
                                <option value="S01" data-harga="1500">Plastik PET</option> [cite: 322, 454]
                                <option value="S02" data-harga="1200">Kardus</option> [cite: 90, 683]
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Berat (kg)</label> [cite: 455, 481, 667, 682, 691, 701, 706]
                            <input type="number" step="0.1" name="berat" id="inputBerat" class="form-control" placeholder="0.0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Harga/kg</label> [cite: 399, 426, 456, 479, 482]
                            <input type="text" id="viewHarga" class="form-control bg-light" value="0" readonly>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded text-center border">
                        <p class="text-muted small mb-1">Total Nilai Setoran</p> [cite: 401, 439, 483]
                        <h3 class="fw-bold text-umi-green" id="totalNilai">Rp 0</h3>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-toggle="modal">Batal</button> [cite: 403, 429, 444, 458, 492, 694, 698, 712]
                    <button type="submit" class="btn btn-umi-green px-4">Simpan Setoran</button> [cite: 402, 428, 443, 491, 710]
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('selectSampah').addEventListener('change', calculateTotal);
    document.getElementById('inputBerat').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const select = document.getElementById('selectSampah');
        const harga = select.options[select.selectedIndex].getAttribute('data-harga') || 0;
        const berat = document.getElementById('inputBerat').value || 0;
        
        document.getElementById('viewHarga').value = new Intl.NumberFormat('id-ID').format(harga);
        
        const total = harga * berat;
        document.getElementById('totalNilai').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
