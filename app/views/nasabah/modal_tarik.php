<div class="modal fade" id="modalTarikSaldo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold">Ajukan Penarikan Saldo</h5> [cite: 834]
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=proses_tarik" method="POST">
                <div class="modal-body p-4 text-center">
                    <p class="text-muted mb-4">Saldo tersedia: <span class="fw-bold text-umi-green">Rp 1.250.000</span></p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Penarikan</label> [cite: 836]
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">Rp</span>
                            <input type="number" name="jumlah" class="form-control border-start-0" placeholder="0" min="10000" required>
                        </div>
                        <div class="form-text mt-2">Permintaan akan diperiksa oleh Bendahara terlebih dahulu.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button> [cite: 839]
                    <button type="submit" class="btn btn-umi-green px-4">Ajukan Sekarang</button> [cite: 838]
                </div>
            </form>
        </div>
    </div>
</div>