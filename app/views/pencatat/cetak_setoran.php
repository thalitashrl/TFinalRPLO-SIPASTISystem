<div id="struk-print" class="p-4 border shadow-sm" style="width: 300px; font-family: monospace;">
    <div class="text-center">
        <h5 class="fw-bold mb-0">SI-PASTI BSU</h5>
        <small>Universitas Muslim Indonesia</small>
        <hr>
    </div>
    <div class="small">
        <p>No: STR-<?= $transaksi['id_setoran'] ?><br>
        Tgl: <?= date('d/m/Y H:i', strtotime($transaksi['tanggal'])) ?><br>
        Nasabah: <?= $transaksi['nama_nasabah'] ?></p>
        <hr>
        <table class="w-100">
            <tr>
                <td><?= $transaksi['nama_sampah'] ?> (<?= $transaksi['berat'] ?>kg)</td>
                <td class="text-end">Rp <?= number_format($transaksi['total']) ?></td>
            </tr>
        </table>
        <hr>
        <p class="text-center fw-bold">SALDO ANDA: Rp <?= number_format($transaksi['saldo_baru']) ?></p>
    </div>
    <div class="text-center small mt-3">
        *Terima kasih telah menabung sampah*
    </div>
</div>
<script>window.print();</script>