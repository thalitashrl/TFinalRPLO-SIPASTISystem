# SI-PASTI (Sistem Informasi Bank Sampah Terintegrasi) ♻️

**SI-PASTI** adalah aplikasi berbasis web yang dibangun menggunakan arsitektur MVC (Model-View-Controller) dengan PHP Native. Aplikasi ini dirancang untuk membantu operasional **Bank Sampah Unit (BSU) Kema Pertika**, mencakup pencatatan setoran sampah nasabah, penarikan saldo, penjualan ke pengepul, hingga pelaporan akuntansi otomatis.

## 📋 Fitur Utama

Aplikasi ini memiliki 4 Hak Akses (Role) dengan fitur spesifik:

### 1. 👤 Administrator (Admin)
* **Dashboard Statistik:** Ringkasan total nasabah, sampah terkumpul, dan arus kas.
* **Kelola Pengguna:** CRUD (Create, Read, Update, Delete) akun petugas dan nasabah.
* **Master Data:** Mengelola jenis sampah dan harga beli/jual.
* **Transaksi:** Akses penuh ke menu Setor, Tarik, dan Jual.
* **Laporan:** Melihat laporan keuangan dan cetak PDF.

### 2. 📝 Pencatat (Petugas Lapangan)
* **Dashboard Operasional:** Fokus pada input data.
* **Catat Setoran:** Menginput penimbangan sampah nasabah di lapangan.

### 3. 💰 Bendahara
* **Dashboard Keuangan:** Ringkasan saldo kas BSU.
* **Validasi Penarikan:** Memproses pencairan dana nasabah.
* **Penjualan Pusat:** Mencatat penjualan sampah dari gudang ke pengepul (Mitra).
* **Cetak Laporan:** Export Laporan Keuangan Bulanan ke PDF.

### 4. 👥 Nasabah
* **Dashboard Personal:** Melihat saldo tabungan saat ini.
* **Riwayat Transaksi:** Memantau mutasi uang masuk (setoran) dan keluar (penarikan).

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP (Tanpa Framework / Native MVC Pattern)
* **Frontend:** HTML5, CSS3, **Bootstrap 5** (Responsive UI)
* **Database:** MySQL / MariaDB
* **Fitur Tambahan:** Native Browser Print (PDF Export tanpa library tambahan)

---

## 💻 Cara Instalasi

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal (Localhost):

1.  **Persiapan Lingkungan:**
    * Pastikan **XAMPP** (atau WAMP/MAMP) sudah terinstall.
    * Pastikan service **Apache** dan **MySQL** sudah berjalan.

2.  **Setup File:**
    * Copy folder `si-pasti` ke dalam folder `htdocs`.
    * Lokasi: `C:\xampp\htdocs\si-pasti`

3.  **Setup Database:**
    * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
    * Buat database baru dengan nama: `si-pasti`.
    * Import file `si_pasti.sql` (https://github.com/user-attachments/files/24299605/si_pasti.sql)

4.  **Jalankan Aplikasi:**
    * Buka browser dan akses:
        ```
        http://localhost/si-pasti/
        ```

---

## 🔐 Akun Demo (Default)

Gunakan akun berikut untuk pengujian sistem:

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin` | *(Sesuai settingan DB)* |
| **Pencatat** | `pencatat` | *(Sesuai settingan DB)* |
| **Bendahara** | `bendahara` | *(Sesuai settingan DB)* |
| **Nasabah** | `nasabah001` | *(Sesuai settingan DB)* |

*(Catatan: Jika lupa password, silakan cek tabel `pengguna` di database atau buat user baru lewat registrasi admin)*

---

## 📂 Struktur Folder (MVC)

```text
si-pasti/
├── app/
│   ├── controllers/   # Logika Pengendali (Admin, Nasabah, Transaksi)
│   ├── models/        # Koneksi & Query Database
│   └── views/         # Tampilan Antarmuka (UI)
│       ├── admin/
│       ├── bendahara/
│       ├── nasabah/
│       └── layouts/   # Sidebar & Navbar
├── public/            # Aset Statis (CSS, JS, Images)
├── index.php          # Router Utama (Pintu Masuk Aplikasi)
└── README.md          # Dokumentasi Proyek
