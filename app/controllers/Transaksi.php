<?php

class Transaksi extends Controller {
    
    // 1. Logika untuk PENCATAT: Simpan Setoran Sampah
    public function simpanSetoran() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_nasabah = $_POST['id_nasabah'];
            $kode_sampah = $_POST['kode_sampah'];
            $berat = $_POST['berat'];
            $id_pencatat = $_SESSION['id_user']; 

            // Ambil harga beli dari Master Sampah
            $sampah = $this->model('MasterSampah')->getByKode($kode_sampah);
            $harga_beli = $sampah['harga_beli_per_kg'];
            $total_rupiah = $berat * $harga_beli;

            // Simpan ke tabel transaksi_setoran & detail_setoran
            $id_setoran = $this->model('SetoranModel')->insert($id_nasabah, $id_pencatat, $total_rupiah);
            $this->model('DetailSetoranModel')->insert($id_setoran, $kode_sampah, $berat, $harga_beli);

            // UPDATE SALDO NASABAH: saldo_akhir = saldo_akhir + total_rupiah [cite: 155]
            $this->model('NasabahModel')->updateSaldo($id_nasabah, $total_rupiah, 'tambah');

            header("Location: index.php?page=dashboard&status=success");
        }
    }

    // 2. Logika untuk BENDAHARA: Penjualan & Margin Keuntungan
    public function prosesPenjualanPusat() {
        $kode_sampah = $_POST['kode_sampah'];
        $berat = $_POST['berat'];
        
        $sampah = $this->model('MasterSampah')->getByKode($kode_sampah);
        $hb = $sampah['harga_beli_per_kg'];
        $hj = $sampah['harga_jual_pusat'];

        $total_bayar_nasabah = $berat * $hb;
        $total_pendapatan_pusat = $berat * $hj;
        $margin = $total_pendapatan_pusat - $total_bayar_nasabah;

        // Simpan ke tabel transaksi_penjualan untuk kas BSU [cite: 634]
        $this->model('PenjualanModel')->insert($berat, $total_pendapatan_pusat, $total_bayar_nasabah, $margin);
        
        header("Location: index.php?page=dashboard&status=sold");
    }

    // 3. Logika untuk NASABAH: Pengajuan Penarikan
    public function ajukanPenarikan() {
        $id_nasabah = $_SESSION['id_nasabah'];
        $jumlah = $_POST['jumlah']; 

        // Simpan dengan status 'Pending' [cite: 567]
        $this->model('PenarikanModel')->request($id_nasabah, $jumlah);
        header("Location: index.php?page=dashboard&msg=waiting_approval");
    }
}