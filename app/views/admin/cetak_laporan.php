<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $data['judul'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus Cetak */
        body { font-family: 'Times New Roman', serif; color: #000; background: #fff; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-text { font-weight: bold; text-transform: uppercase; }
        .table thead th { background-color: #f0f0f0 !important; border: 1px solid #000; color: #000; }
        .table td { border: 1px solid #000; }
        
        /* Sembunyikan elemen saat dicetak jika perlu */
        @media print {
            @page { size: A4; margin: 2cm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        
        <div class="text-center kop-surat">
            <h4 class="logo-text m-0">BANK SAMPAH UNIT (BSU)</h4>
            <h2 class="logo-text m-0">KEMA PERTIKA</h2>
            <p class="m-0 small">Jl. Perintis Kemerdekaan KM.10, Tamalanrea, Makassar</p>
            <p class="m-0 small">Email: bsu.kemapertika@gmail.com | Telp: 0812-3456-7890</p>
        </div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-decoration-underline">LAPORAN KEUANGAN BULANAN</h5>
            <p>Periode: <?= date('F Y', strtotime($data['bulan'])) ?></p>
        </div>

        <table class="table table-bordered table-sm">
            <thead>
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Jenis</th>
                    <th>Keterangan</th>
                    <th width="15%">Debit (Masuk)</th>
                    <th width="15%">Kredit (Keluar)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $totalMasuk = 0;
                $totalKeluar = 0;
                
                if ($data['transaksi'] && $data['transaksi']->num_rows > 0):
                    foreach($data['transaksi'] as $row): 
                        $totalMasuk += $row['masuk'];
                        $totalKeluar += $row['keluar'];
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td class="text-center text-uppercase small"><?= $row['jenis'] ?></td>
                    <td><?= $row['keterangan'] ?? '-' ?></td>
                    <td class="text-end"><?= $row['masuk'] > 0 ? 'Rp '.number_format($row['masuk']) : '-' ?></td>
                    <td class="text-end"><?= $row['keluar'] > 0 ? 'Rp '.number_format($row['keluar']) : '-' ?></td>
                </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center fst-italic">Tidak ada transaksi pada bulan ini.</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="fw-bold bg-light">
                <tr>
                    <td colspan="4" class="text-end pe-3">TOTAL</td>
                    <td class="text-end">Rp <?= number_format($totalMasuk) ?></td>
                    <td class="text-end">Rp <?= number_format($totalKeluar) ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end pe-3">SALDO BERSIH (MARGIN)</td>
                    <td colspan="2" class="text-center bg-warning bg-opacity-10">
                        Rp <?= number_format($totalMasuk - $totalKeluar) ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <div class="col-4 offset-8 text-center">
                <p class="mb-5">Makassar, <?= date('d F Y') ?><br>Mengetahui, Bendahara</p>
                <br>
                <p class="fw-bold text-decoration-underline mt-4">( .................................... )</p>
            </div>
        </div>

    </div>

    <div class="fixed-bottom p-3 text-center no-print bg-white border-top">
        <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
            <i class="bi bi-printer"></i> Cetak Lagi
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-4">
            Tutup
        </button>
    </div>

</body>
</html>