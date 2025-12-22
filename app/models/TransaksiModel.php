<?php
class TransaksiModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Fungsi Cerdas: Mencari nama kolom yang valid di database.
     * Jika $preferred tidak ada, dia akan mencari alternatif berdasarkan kata kunci.
     */
    private function getValidColumn($table, $preferred, $type = 'amount') {
        // 1. Ambil daftar semua kolom di tabel tersebut
        $result = $this->db->query("SHOW COLUMNS FROM $table");
        if (!$result) return null; // Jika tabel tidak ada

        $columns = [];
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        
        // 2. Cek apakah kolom yang kita inginkan (preferred) ada?
        if (in_array($preferred, $columns)) return $preferred;
        
        // 3. Jika tidak ada, cari alternatif berdasarkan tipe data
        foreach ($columns as $col) {
            if ($type == 'amount') {
                // Cari kolom berbau uang/angka
                if (preg_match('/(total|harga|jumlah|nominal|pendapatan|debit|kredit)/i', $col)) return $col;
            } elseif ($type == 'date') {
                // Cari kolom berbau tanggal/waktu
                if (preg_match('/(tgl|tanggal|date|time|waktu|created_at)/i', $col)) return $col;
            }
        }
        
        // 4. Fallback darurat (kembalikan kolom kedua atau null)
        return $columns[1] ?? 'id'; 
    }

    public function getTotalSetoran() {
        // Cari kolom uang di tabel setoran
        $col = $this->getValidColumn('transaksi_setoran', 'total_harga', 'amount');
        if (!$col) return 0;
        
        $query = "SELECT SUM($col) as total FROM transaksi_setoran";
        return $this->db->query($query)->fetch_assoc()['total'] ?? 0;
    }

    public function getTotalPenjualan() {
        // Cari kolom uang di tabel penjualan
        $col = $this->getValidColumn('transaksi_penjualan', 'total_pendapatan', 'amount');
        if (!$col) return 0;

        $query = "SELECT SUM($col) as total FROM transaksi_penjualan";
        return $this->db->query($query)->fetch_assoc()['total'] ?? 0;
    }

    public function getTotalPenarikan() {
        // Cari kolom uang di tabel penarikan
        $col = $this->getValidColumn('transaksi_penarikan', 'jumlah_penarikan', 'amount');
        if (!$col) return 0;

        $query = "SELECT SUM($col) as total FROM transaksi_penarikan";
        return $this->db->query($query)->fetch_assoc()['total'] ?? 0;
    }

    public function getRiwayatTransaksi($limit = 10) {
        // Deteksi Nama Kolom Tanggal & Harga untuk masing-masing tabel
        // Agar query UNION tidak error 'Unknown Column'
        
        $tglSetor = $this->getValidColumn('transaksi_setoran', 'tgl_setoran', 'date');
        $uangSetor = $this->getValidColumn('transaksi_setoran', 'total_harga', 'amount');

        $tglJual = $this->getValidColumn('transaksi_penjualan', 'tgl_penjualan', 'date');
        $uangJual = $this->getValidColumn('transaksi_penjualan', 'total_pendapatan', 'amount');

        $tglTarik = $this->getValidColumn('transaksi_penarikan', 'tgl_penarikan', 'date');
        $uangTarik = $this->getValidColumn('transaksi_penarikan', 'jumlah_penarikan', 'amount');

        // Gunakan nama kolom yang ditemukan dalam Query
        // Kita gunakan '0' atau '1' dummy jika kolom uang tidak ditemukan agar query tetap jalan
        $colDebitSetor = $uangSetor ? $uangSetor : '0';
        $colKreditJual = $uangJual ? $uangJual : '0';
        $colKreditTarik = $uangTarik ? $uangTarik : '0';

        $query = "
            (SELECT 'Setoran' as jenis, $tglSetor as tanggal, 'Setoran Sampah Nasabah' as keterangan, $colDebitSetor as debit, 0 as kredit FROM transaksi_setoran)
            UNION ALL
            (SELECT 'Penjualan' as jenis, $tglJual as tanggal, 'Penjualan ke Pengepul' as keterangan, 0 as debit, $colKreditJual as kredit FROM transaksi_penjualan)
            UNION ALL
            (SELECT 'Penarikan' as jenis, $tglTarik as tanggal, 'Penarikan Saldo' as keterangan, 0 as debit, $colKreditTarik as kredit FROM transaksi_penarikan)
            ORDER BY tanggal DESC LIMIT $limit
        ";
        
        return $this->db->query($query);
    }

    // --- FITUR BARU: TAMBAH SETORAN ---
    public function tambahSetoran($data) {
        $id_nasabah = $data['id_nasabah'];
        $id_sampah = $data['id_sampah'];
        $berat = $data['berat'];
        $total = $data['total_harga'];
        $tanggal = date('Y-m-d H:i:s');

        // Query Insert Data Transaksi
        $query = "INSERT INTO transaksi_setoran (id_nasabah, id_sampah, berat, total_harga, tgl_setoran) 
                  VALUES ('$id_nasabah', '$id_sampah', '$berat', '$total', '$tanggal')";
        
        return $this->db->query($query);
    }

    // --- FITUR BARU: SIMPAN PENARIKAN ---
    public function tambahPenarikan($data) {
        $id_nasabah = $data['id_nasabah'];
        $jumlah = $data['jumlah_penarikan'];
        $tanggal = date('Y-m-d H:i:s');

        // Pastikan tabel transaksi_penarikan memiliki kolom yang sesuai!
        $query = "INSERT INTO transaksi_penarikan (id_nasabah, jumlah_penarikan, tgl_penarikan) 
                  VALUES ('$id_nasabah', '$jumlah', '$tanggal')";
        
        return $this->db->query($query);
    }

    // --- FITUR BARU: SIMPAN PENJUALAN KE PENGEPUL ---
    public function tambahPenjualan($data) {
        $id_sampah = $data['id_sampah'];
        $berat = $data['berat'];
        $harga = $data['harga_per_kg'];
        $total = $data['total_pendapatan'];
        $pengepul = $data['tujuan_pengepul'];
        $tanggal = date('Y-m-d H:i:s');

        $query = "INSERT INTO transaksi_penjualan 
                  (id_sampah, berat, harga_per_kg, total_pendapatan, tujuan_pengepul, tgl_penjualan) 
                  VALUES ('$id_sampah', '$berat', '$harga', '$total', '$pengepul', '$tanggal')";
        
        return $this->db->query($query);
    }

    // Hitung Total Berat Sampah (Dari transaksi setoran)
    public function getTotalBeratSampah() {
        // Gunakan getValidColumn agar aman seperti sebelumnya
        $col = $this->getValidColumn('transaksi_setoran', 'berat', 'amount');
        if (!$col) return 0;

        $query = "SELECT SUM($col) as total FROM transaksi_setoran";
        $result = $this->db->query($query)->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // --- FITUR BARU: RIWAYAT KHUSUS NASABAH ---
    public function getRiwayatPerNasabah($id_user_login) {
        // Cari dulu ID Nasabah berdasarkan ID User login
        // (Asumsi: di tabel nasabah ada kolom id_pengguna yang berelasi ke tabel pengguna)
        // Jika struktur tabel nasabah Anda menggunakan id_nasabah sebagai primary key terpisah:
        $qNasabah = "SELECT id_nasabah FROM nasabah WHERE id_pengguna = '$id_user_login'";
        $resNasabah = $this->db->query($qNasabah);
        
        // Cek jika data nasabah ditemukan
        if ($resNasabah && $resNasabah->num_rows > 0) {
            $row = $resNasabah->fetch_assoc();
            $id = $row['id_nasabah'];
        } else {
            // Fallback: Jika id_pengguna sama dengan id_nasabah (tergantung desain DB Anda)
            $id = $id_user_login; 
        }

        // Query Union (Setoran & Penarikan)
        $query = "
            (SELECT 'Setor Sampah' as jenis, tgl_setoran as tanggal, total_harga as masuk, 0 as keluar, berat as info_berat 
             FROM transaksi_setoran WHERE id_nasabah = '$id')
            UNION ALL
            (SELECT 'Tarik Saldo' as jenis, tgl_penarikan as tanggal, 0 as masuk, jumlah_penarikan as keluar, 0 as info_berat 
             FROM transaksi_penarikan WHERE id_nasabah = '$id')
            ORDER BY tanggal DESC
        ";

        return $this->db->query($query);
    }

    // --- FITUR BARU: HITUNG SALDO KAS BSU (Untuk Dashboard Bendahara) ---
    public function getSaldoKas() {
        // 1. Hitung Total Pemasukan (Jual Sampah ke Pengepul)
        $queryJual = "SELECT SUM(total_pendapatan) as total FROM transaksi_penjualan";
        $resultJual = $this->db->query($queryJual)->fetch_assoc();
        $totalMasuk = $resultJual['total'] ?? 0;

        // 2. Hitung Total Pengeluaran (Nasabah Tarik Saldo)
        $queryTarik = "SELECT SUM(jumlah_penarikan) as total FROM transaksi_penarikan";
        $resultTarik = $this->db->query($queryTarik)->fetch_assoc();
        $totalKeluar = $resultTarik['total'] ?? 0;

        // 3. Kembalikan selisihnya
        return $totalMasuk - $totalKeluar;
    }

    // --- KHUSUS DASHBOARD NASABAH ---
    
    // 1. Ambil Total Berat Sampah Milik Nasabah Tertentu
    public function getTotalBeratByNasabah($id_nasabah) {
        // Ambil id_nasabah yang valid (jika pakai relasi user)
        // (Asumsi $id_nasabah yang dikirim sudah benar ID tabel nasabah)
        
        $query = "SELECT SUM(berat) as total FROM transaksi_setoran WHERE id_nasabah = '$id_nasabah'";
        $result = $this->db->query($query)->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // 2. Ambil Total Penarikan Milik Nasabah Tertentu
    public function getTotalPenarikanByNasabah($id_nasabah) {
        $query = "SELECT SUM(jumlah_penarikan) as total FROM transaksi_penarikan WHERE id_nasabah = '$id_nasabah'";
        $result = $this->db->query($query)->fetch_assoc();
        return $result['total'] ?? 0;
    }
}