<?php

class Bendahara extends Controller {
public function validasiPenarikan($id_penarikan, $aksi) {
    // 1. Ambil detail penarikan
    $data = $this->model('PenarikanModel')->getById($id_penarikan);
    $id_nasabah = $data['id_nasabah'];
    $jumlah = $data['jumlah_rupiah'];

    if ($aksi == 'setujui') {
        // Cek apakah saldo nasabah mencukupi
        $nasabah = $this->model('NasabahModel')->getById($id_nasabah);
        if ($nasabah['saldo_akhir'] >= $jumlah) {
            // Update status transaksi
            $this->model('PenarikanModel')->updateStatus($id_penarikan, 'Berhasil', $_SESSION['id_user']);
            // Kurangi saldo nasabah secara real-time
            $this->model('NasabahModel')->updateSaldo($id_nasabah, $jumlah, 'kurang');
        }
    } else {
        $this->model('PenarikanModel')->updateStatus($id_penarikan, 'Ditolak', $_SESSION['id_user']);
    }
    header("Location: index.php?page=validasi_penarikan");
} 
}