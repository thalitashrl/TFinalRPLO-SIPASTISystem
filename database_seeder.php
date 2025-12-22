<?php
require_once 'app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

echo "Memulai Seeding Database SI-PASTI...\n";

// 1. Clear Data Lama (Opsional - Berhati-hatilah)
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("TRUNCATE TABLE detail_setoran");
$conn->query("TRUNCATE TABLE transaksi_setoran");
$conn->query("TRUNCATE TABLE transaksi_penarikan");
$conn->query("TRUNCATE TABLE nasabah");
$conn->query("TRUNCATE TABLE pengguna");
$conn->query("TRUNCATE TABLE master_sampah");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

// 2. Seed Pengguna (Sesuai Demo Prototipe)
// Password di-hash agar aman
$users = [
    ['admin', password_hash('admin123', PASSWORD_DEFAULT), 'Suryani', 'Admin'], // [cite: 9, 74, 178]
    ['arni', password_hash('arni123', PASSWORD_DEFAULT), 'Arni', 'Pencatat'], // [cite: 10, 299, 389]
    ['rahmatia', password_hash('rahmatia123', PASSWORD_DEFAULT), 'St. Rahmatia', 'Bendahara'], // [cite: 11, 169, 651]
    ['nasabah001', password_hash('nasabah123', PASSWORD_DEFAULT), 'Budi Santoso', 'Nasabah'] // [cite: 12, 24, 417]
];

foreach ($users as $u) {
    $conn->query("INSERT INTO pengguna (username, password, nama_lengkap, role) VALUES ('$u[0]', '$u[1]', '$u[2]', '$u[3]')");
}

// 3. Seed Nasabah (Hubungkan ke user nasabah001)
$id_user_nasabah = $conn->insert_id;
$conn->query("INSERT INTO nasabah (id_pengguna, alamat, no_telepon, saldo_akhir) 
              VALUES ($id_user_nasabah, 'Jl. Racing Centre No. 5', '081234567890', 1250000)"); // [cite: 145, 156, 171, 788]

// 4. Seed Master Sampah (Sesuai Data Prototipe)
$sampah = [
    ['S01', 'Plastik PET', 1500, 1800], // [cite: 322, 454, 457, 479]
    ['S02', 'Kardus', 1200, 1500],     // [cite: 90, 326, 427, 482, 683]
    ['S03', 'Botol Kaca', 1000, 1300], // [cite: 330, 635, 707]
    ['S04', 'Kaleng', 2000, 2500]      // [cite: 334, 453, 683]
];

foreach ($sampah as $s) {
    $conn->query("INSERT INTO master_sampah (kode_sampah, nama_sampah, harga_beli_per_kg, harga_jual_pusat) 
                  VALUES ('$s[0]', '$s[1]', $s[2], $s[3])");
}

echo "Seeding Selesai! Akun admin: admin/admin123 siap digunakan.\n";