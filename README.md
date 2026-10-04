# 🏗️ Sistem Informasi Penyewaan Alat Konstruksi

### CV. HK Satu Tujuh Lampung

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Native-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Native">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/Architecture-MVC-success?style=for-the-badge" alt="MVC">
</p>

## 📌 Tentang Sistem

**Sistem Informasi Penyewaan Alat Konstruksi** merupakan aplikasi berbasis web yang dirancang untuk membantu proses pengelolaan penyewaan alat konstruksi pada **CV. HK Satu Tujuh Lampung**.

Sistem ini dikembangkan sebagai solusi terhadap proses penyewaan yang sebelumnya masih dilakukan secara manual melalui komunikasi WhatsApp, pencatatan ketersediaan alat menggunakan media kertas, serta pengiriman bukti pembayaran melalui WhatsApp.

Dengan adanya sistem ini, proses penyewaan dapat dilakukan secara lebih terstruktur mulai dari pengelolaan data alat konstruksi, pelanggan, transaksi penyewaan, pembayaran, hingga pemantauan status penyewaan.

---

## 🎯 Tujuan

Sistem ini bertujuan untuk:

* Mempermudah pelanggan dalam melihat informasi alat konstruksi yang tersedia.
* Mempermudah pelanggan melakukan proses penyewaan secara online.
* Membantu pengelola dalam mengelola data alat konstruksi.
* Membantu pengelola mengelola data pelanggan dan transaksi penyewaan.
* Mempermudah proses pengelolaan dan verifikasi bukti pembayaran.
* Memudahkan pemantauan status penyewaan.
* Mengurangi risiko kesalahan pencatatan data secara manual.
* Menyediakan informasi penyewaan yang lebih terstruktur.

---

## ✨ Fitur Utama

### 👤 Pelanggan

Pelanggan dapat:

* Registrasi akun.
* Login dan logout.
* Melihat informasi alat konstruksi.
* Melihat detail alat konstruksi.
* Melakukan penyewaan alat.
* Melihat riwayat penyewaan.
* Mengunggah bukti pembayaran.
* Melihat status pembayaran.
* Melihat status penyewaan.
* Melihat informasi pengembalian alat.
* Mengunduh bukti penyewaan dalam format PDF.

### 👨‍💼 Administrator & Pimpinan

Administrator dan Pimpinan memiliki akses untuk:

* Login ke halaman administrasi.
* Mengelola data alat konstruksi.
* Mengelola data pelanggan.
* Mengelola transaksi penyewaan.
* Mengelola data pembayaran.
* Memverifikasi bukti pembayaran.
* Mengubah status pembayaran.
* Mengubah status penyewaan.
* Mengelola proses pengembalian alat.
* Melihat dan mengelola laporan penyewaan.

### 🧑‍💼 Bagian Penjualan

Bagian Penjualan dapat:

* Mengelola transaksi penyewaan.
* Mengelola data pelanggan.
* Memantau transaksi penyewaan.
* Memproses penyewaan pelanggan.
* Mengubah status penyewaan menjadi:

  * Diproses
  * Selesai
  * Dibatalkan

---

## 🔄 Alur Sistem

```text
Pelanggan
   │
   ▼
Registrasi / Login
   │
   ▼
Melihat Alat Konstruksi
   │
   ▼
Memilih Alat
   │
   ▼
Melakukan Penyewaan
   │
   ▼
Melakukan Pembayaran
   │
   ▼
Upload Bukti Pembayaran
   │
   ▼
Verifikasi Pembayaran
   │
   ├── Ditolak
   │      │
   │      └── Upload ulang bukti pembayaran
   │
   └── Disetujui
          │
          ▼
   Penyewaan Diproses
          │
          ▼
   Alat Disewa
          │
          ▼
   Pengembalian Alat
          │
          ▼
   Penyewaan Selesai
```

---

## 🛠️ Teknologi yang Digunakan

| Teknologi        | Keterangan                  |
| ---------------- | --------------------------- |
| **PHP Native**   | Bahasa pemrograman utama    |
| **MySQL**        | Sistem manajemen basis data |
| **HTML5**        | Struktur halaman website    |
| **CSS3**         | Styling website             |
| **Bootstrap 5**  | Framework antarmuka         |
| **JavaScript**   | Interaksi pada halaman      |
| **Composer**     | Pengelolaan dependency PHP  |
| **MVC**          | Arsitektur aplikasi         |
| **Apache**       | Web server                  |
| **Git & GitHub** | Version control             |

---

## 🏛️ Arsitektur Sistem

Aplikasi menggunakan konsep **MVC (Model - View - Controller)** yang dibuat menggunakan PHP Native.

```text
HKSatutujuh_Konstruksi/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── config/
│   └── ...
│
├── core/
│   └── ...
│
├── public/
│   ├── assets/
│   ├── css/
│   ├── js/
│   └── uploads/
│
├── vendor/
│
├── .htaccess
├── RouterMapping.php
├── composer.json
├── composer.lock
├── index.php
├── penyewaan.sql
└── README.md
```

### Model

Digunakan untuk menangani data dan komunikasi dengan database MySQL.

### View

Digunakan untuk menampilkan antarmuka kepada pengguna, baik halaman pelanggan maupun halaman administrasi.

### Controller

Digunakan untuk menangani proses bisnis dan menghubungkan Model dengan View.

---

## 💾 Database

Database yang digunakan dalam aplikasi adalah **MySQL**.

File database tersedia pada:

```text
penyewaan.sql
```

Database digunakan untuk menyimpan data yang berkaitan dengan:

* User
* Pelanggan
* Alat Konstruksi
* Penyewaan
* Detail Penyewaan
* Pembayaran
* Pengembalian
* Data pendukung lainnya

---

## ⚙️ Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

* PHP 8.x atau versi yang sesuai dengan project.
* MySQL / MariaDB.
* Apache Web Server.
* XAMPP / Laragon.
* Composer.
* Web Browser seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge.

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/ariienf/HKSatutujuh_Konstruksi.git
```

Masuk ke folder project:

```bash
cd HKSatutujuh_Konstruksi
```

### 2. Install Dependency

Jalankan:

```bash
composer install
```

### 3. Membuat Database

Buka **phpMyAdmin**, kemudian buat database baru, misalnya:

```text
penyewaan
```

### 4. Import Database

Import file:

```text
penyewaan.sql
```

ke database `penyewaan`.

### 5. Konfigurasi Database

Sesuaikan konfigurasi database pada file konfigurasi aplikasi dengan pengaturan MySQL pada komputer masing-masing.

Contoh:

```php
'host'     => 'localhost',
'database' => 'penyewaan',
'username' => 'root',
'password' => ''
```

> Sesuaikan nilai tersebut dengan konfigurasi database pada lingkungan lokal Anda.

### 6. Jalankan Aplikasi

Jika menggunakan XAMPP, letakkan project pada:

```text
C:/xampp/htdocs/
```

Kemudian aktifkan:

```text
Apache
MySQL
```

Buka browser dan akses:

```text
http://localhost/HKSatutujuh_Konstruksi/
```

---

## 👥 Hak Akses Pengguna

| Role              | Akses                                                                                           |
| ----------------- | ----------------------------------------------------------------------------------------------- |
| **Pelanggan**     | Registrasi, login, melihat alat, penyewaan, upload bukti pembayaran, melihat status dan riwayat |
| **Administrator** | Mengelola seluruh data dan proses sistem                                                        |
| **Pimpinan**      | Mengelola dan memantau seluruh data serta laporan                                               |
| **Penjualan**     | Mengelola transaksi, pelanggan, dan status penyewaan                                            |

---

## 📋 Status Penyewaan

Sistem menyediakan beberapa status untuk membantu proses monitoring penyewaan:

```text
Menunggu
    ↓
Diproses
    ↓
Selesai
```

Jika transaksi tidak dapat dilanjutkan:

```text
Menunggu / Diproses
        ↓
    Dibatalkan
```

---

## 💳 Proses Pembayaran

Sistem menggunakan mekanisme **upload bukti pembayaran**.

Alurnya:

```text
Pelanggan melakukan penyewaan
             ↓
      Melakukan pembayaran
             ↓
      Upload bukti pembayaran
             ↓
     Admin melakukan verifikasi
             ↓
       ┌─────┴─────┐
       ↓           ↓
   Disetujui     Ditolak
       ↓           ↓
  Diproses     Upload ulang
```

---

## 📄 Output Sistem

Sistem menghasilkan beberapa informasi dan dokumen, antara lain:

* Informasi alat konstruksi.
* Data pelanggan.
* Data transaksi penyewaan.
* Status pembayaran.
* Status penyewaan.
* Riwayat penyewaan.
* Informasi pengembalian alat.
* Bukti penyewaan dalam format PDF.
* Laporan transaksi penyewaan.

---

## 📸 Tampilan Sistem

> Tambahkan screenshot aplikasi pada bagian ini untuk membuat repository lebih informatif.

Contoh:

```markdown
### Halaman Beranda

![Halaman Beranda](public/assets/img/home.png)

### Halaman Data Alat

![Data Alat](public/assets/img/alat.png)

### Halaman Penyewaan

![Penyewaan](public/assets/img/penyewaan.png)

### Dashboard Administrator

![Dashboard](public/assets/img/dashboard.png)
```

---

## 📁 Struktur Hak Akses

```text
                    SISTEM INFORMASI
                 PENYEWAAN ALAT KONSTRUKSI
                           │
          ┌────────────────┼────────────────┐
          │                │                │
      Pelanggan       Administrator      Pimpinan
          │                │                │
          │                └───────┬────────┘
          │                        │
          │                  Kelola Sistem
          │                        │
          └───────────┐            │
                      ▼            ▼
                 Penyewaan     Laporan
                      │
                      ▼
                 Pembayaran
                      │
                      ▼
                  Pengembalian
```

---

## 🎓 Tujuan Pengembangan

Project ini dikembangkan sebagai implementasi dari penelitian dengan judul:

> **"Perancangan Sistem Informasi Penyewaan Alat Konstruksi Berbasis Web pada CV. HK Satu Tujuh Lampung"**

Sistem dikembangkan untuk menerapkan konsep perancangan dan pembangunan sistem informasi berbasis web dalam mendukung proses bisnis penyewaan alat konstruksi.

---

## 🔮 Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dilakukan pada versi berikutnya:

* Notifikasi status penyewaan.
* Notifikasi pembayaran.
* Dashboard statistik yang lebih lengkap.
* Export laporan ke Excel.
* Export laporan ke PDF.
* Integrasi WhatsApp notification.
* Pengembangan sistem menjadi Progressive Web App (PWA).
* Peningkatan UI/UX.
* Pengembangan fitur monitoring alat.

---

## 👨‍💻 Developer

**Arie Nur Fauzi**

Sistem Informasi
Universitas Bina Sarana Informatika

GitHub:

[github.com/ariienf](https://github.com/ariienf?utm_source=chatgpt.com)

Repository:

[HKSatutujuh_Konstruksi](https://github.com/ariienf/HKSatutujuh_Konstruksi?utm_source=chatgpt.com)

---

## 📜 Lisensi

Project ini dibuat untuk keperluan **akademik, penelitian, dan pengembangan sistem informasi**.

© 2026 Arie Nur Fauzi — HK Satu Tujuh Konstruksi
