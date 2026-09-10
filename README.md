# POS-APP

<p align="center">
  <strong>Point of Sale & Inventory Management System</strong>
</p>

<p align="center">
  Sistem Point of Sale (POS) berbasis web untuk membantu mengelola transaksi penjualan, produk, persediaan, pelanggan, supplier, pengguna, dan operasional toko secara terintegrasi.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/CSS-1572B6?style=flat-square&logo=css3&logoColor=white" alt="CSS">
  <img src="https://img.shields.io/badge/HTML-E34F26?style=flat-square&logo=html5&logoColor=white" alt="HTML">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/SCSS-CC6699?style=flat-square&logo=sass&logoColor=white" alt="SCSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square&logo=opensourceinitiative&logoColor=white" alt="MIT License">
  <img src="https://img.shields.io/badge/CodeIgniter%204-EF4223?style=flat-square&logo=codeigniter&logoColor=white" alt="CodeIgniter 4">
</p>

---

## Tentang Project

**POS-APP** adalah aplikasi Point of Sale berbasis web yang dikembangkan menggunakan **CodeIgniter 4** dan PHP.

Aplikasi ini dirancang untuk membantu toko atau bisnis retail dalam mengelola proses operasional utama, mulai dari pengelolaan produk dan stok hingga proses transaksi penjualan.

Project ini juga menggunakan pendekatan modular melalui Controller, Model, Filter, Migration, Seeder, dan View sehingga kode lebih mudah dikembangkan dan dipelihara.

### Tujuan

POS-APP dikembangkan untuk:

* Mempermudah proses transaksi penjualan.
* Mengelola data produk secara terpusat.
* Memantau dan mengelola stok barang.
* Mengelola kategori dan satuan produk.
* Mengelola pelanggan dan supplier.
* Mengelola pengguna aplikasi berdasarkan hak akses.
* Menyediakan dashboard untuk memantau informasi operasional.
* Menghasilkan dokumen PDF menggunakan Dompdf.
* Menyediakan struktur aplikasi yang mudah dikembangkan.

---

## Fitur Utama

### Dashboard

Dashboard menyediakan ringkasan informasi operasional aplikasi sehingga pengguna dapat melihat informasi penting secara lebih terstruktur.

Fitur dashboard meliputi:

* Ringkasan data operasional.
* Informasi produk.
* Informasi stok.
* Informasi transaksi.
* Statistik yang diperlukan untuk pemantauan aplikasi.

---

### Point of Sale

Modul POS digunakan untuk menjalankan proses transaksi penjualan.

Fitur yang tersedia mencakup:

* Pengelolaan keranjang transaksi.
* Pemilihan produk.
* Perhitungan subtotal.
* Perhitungan total transaksi.
* Pengelolaan customer.
* Penyelesaian transaksi.
* Penyimpanan detail transaksi.
* Riwayat transaksi.

---

### Manajemen Produk

Pengelolaan produk menjadi salah satu bagian utama aplikasi.

Fitur meliputi:

* Tambah produk.
* Edit produk.
* Hapus produk.
* Informasi harga.
* Informasi stok.
* Kategori produk.
* Satuan produk.
* Identitas produk.

---

### Manajemen Kategori

Modul kategori digunakan untuk mengelompokkan produk agar lebih mudah dikelola dan dicari.

Fitur:

* Tambah kategori.
* Edit kategori.
* Hapus kategori.
* Pengelompokan produk berdasarkan kategori.

---

### Manajemen Stok

Modul stok digunakan untuk membantu memantau persediaan barang.

Fitur:

* Stok barang.
* Pencatatan perubahan stok.
* Penambahan stok.
* Pengurangan stok melalui transaksi.
* Monitoring persediaan.

---

### Customer Management

Modul customer digunakan untuk menyimpan dan mengelola data pelanggan.

Fitur:

* Tambah customer.
* Edit customer.
* Hapus customer.
* Informasi customer.
* Integrasi dengan transaksi penjualan.

---

### Supplier Management

Modul supplier digunakan untuk mengelola informasi pemasok barang.

Fitur:

* Tambah supplier.
* Edit supplier.
* Hapus supplier.
* Informasi supplier.

---

### User Management

Aplikasi menyediakan pengelolaan pengguna dan hak akses.

Fitur:

* Manajemen user.
* Autentikasi pengguna.
* Hak akses administrator.
* Filter akses berdasarkan role.

---

### Pengaturan Aplikasi

Modul settings digunakan untuk mengelola konfigurasi aplikasi.

Pengaturan dapat digunakan untuk menyesuaikan informasi yang berkaitan dengan operasional aplikasi.

---

### PDF Generation

POS-APP menggunakan **Dompdf** untuk menghasilkan dokumen berbasis PDF.

Teknologi ini dapat digunakan untuk kebutuhan seperti:

* Cetak dokumen transaksi.
* Export dokumen.
* Generate laporan dalam format PDF.

---

## Tech Stack

| Komponen             | Teknologi       |
| -------------------- | --------------- |
| Programming Language | PHP 8.2+        |
| Framework            | CodeIgniter 4   |
| Database             | MySQL / MariaDB |
| Dependency Manager   | Composer        |
| PDF Generator        | Dompdf          |
| Testing              | PHPUnit         |
| Architecture         | MVC             |
| Web Server           | Apache / Nginx  |

Versi PHP minimum yang didefinisikan oleh project adalah **PHP 8.2**, sedangkan dependency utama yang digunakan adalah CodeIgniter 4.7 dan Dompdf 3.1.

---

## Arsitektur Aplikasi

Project menggunakan pola **Model-View-Controller (MVC)** dari CodeIgniter 4.

Struktur utama aplikasi:

```text
POS-APP/
│
├── app/
│   ├── Config/
│   │
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── Category.php
│   │   ├── Customer.php
│   │   ├── Dashboard.php
│   │   ├── Item.php
│   │   ├── Pos.php
│   │   ├── Settings.php
│   │   ├── Stock.php
│   │   ├── Supplier.php
│   │   ├── Unit.php
│   │   └── User.php
│   │
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeds/
│   │
│   ├── Filters/
│   │   ├── AdminFilter.php
│   │   └── AuthFilter.php
│   │
│   ├── Helpers/
│   ├── Language/
│   ├── Libraries/
│   ├── Models/
│   │   ├── CartModel.php
│   │   ├── CategoryModel.php
│   │   ├── CustomerModel.php
│   │   ├── DashboardModel.php
│   │   ├── ItemModel.php
│   │   ├── ProductModel.php
│   │   ├── SaleModel.php
│   │   ├── SaleDetailModel.php
│   │   ├── SettingModel.php
│   │   ├── StockModel.php
│   │   ├── SupplierModel.php
│   │   ├── UnitModel.php
│   │   └── UserModel.php
│   │
│   ├── ThirdParty/
│   └── Views/
│
├── public/
├── tests/
├── writable/
│
├── builds/
├── composer.json
├── composer.lock
├── phpunit.dist.xml
├── preload.php
├── spark
├── LICENSE
└── README.md
```

Struktur repository dan modul tersebut mengikuti struktur aktual pada repository POS-APP.

---

## Requirements

Sebelum melakukan instalasi, pastikan environment telah memenuhi persyaratan berikut:

* PHP **8.2 atau lebih baru**
* Composer
* MySQL atau MariaDB
* Apache atau Nginx
* PHP Extensions yang diperlukan oleh CodeIgniter 4
* Git

Untuk penggunaan MySQL, pastikan extension database PHP telah aktif.

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/yolanchndr/POS-APP.git
```

Masuk ke direktori project:

```bash
cd POS-APP
```

---

### 2. Install Dependency

Jalankan Composer:

```bash
composer install
```

---

### 3. Konfigurasi Environment

Salin file environment:

```bash
cp env .env
```

Kemudian buka file:

```text
.env
```

Sesuaikan konfigurasi aplikasi, terutama:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/POS-APP/public'
```

Sesuaikan `baseURL` dengan konfigurasi server lokal Anda.

---

### 4. Pastikan Folder Cache Tersedia

CodeIgniter 4 membutuhkan folder `writable/cache` untuk menyimpan file cache.

Pastikan folder `cache` sudah tersedia sebelum menjalankan migration atau menggunakan aplikasi.

Jika folder belum ada, buat dengan perintah:

```bash
mkdir -p writable/cache
```

Kemudian periksa permission dan keberadaan folder:

```bash
ls -ld writable writable/cache
```

Contoh hasil:

```text
drwxr-xr-x  writable
drwxr-xr-x  writable/cache
```

Pastikan web server atau PHP memiliki permission untuk menulis ke folder `writable/`, khususnya:

```text
writable/cache/
```

> Pada environment Linux, permission folder `writable/` perlu disesuaikan dengan user yang menjalankan PHP atau web server.

---

## Database Configuration

Konfigurasi database dapat dilakukan melalui file `.env`.

Contoh:

```ini
database.default.hostname = localhost
database.default.database = pos
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

Sesuaikan:

* Nama database
* Username database
* Password database
* Host
* Port

dengan environment Anda.

---

## Database Migration

Project menyediakan struktur database melalui **CodeIgniter 4 Migration** dan **Seeder**.

Setelah database dikonfigurasi dan folder `writable/cache` tersedia, jalankan migration:

```bash
php spark migrate
```

Jika project memiliki seeder yang diperlukan:

```bash
php spark db:seed DatabaseSeeder
```

> Nama seeder dapat disesuaikan dengan seeder yang tersedia pada folder `app/Database/Seeds/`.

---

## Menjalankan Aplikasi

### Menggunakan CodeIgniter Development Server

Jalankan:

```bash
php spark serve
```

Kemudian buka:

```text
http://localhost:8080
```

---

### Menggunakan Apache / Nginx

Untuk production atau deployment menggunakan web server, **document root sebaiknya diarahkan ke folder `public/`**, bukan ke root repository.

Contoh:

```text
POS-APP/
└── public/
    └── index.php
```

Hal ini merupakan pola standar CodeIgniter 4 untuk memisahkan file publik dari source code aplikasi.

---

## Testing

Project telah menyediakan konfigurasi PHPUnit.

Untuk menjalankan seluruh test:

```bash
composer test
```

atau:

```bash
vendor/bin/phpunit
```

Konfigurasi dependency development dan script testing tersedia pada `composer.json`.

---

## Security

Beberapa hal yang perlu diperhatikan ketika melakukan deployment:

1. Jangan menggunakan environment `development` pada server production.
2. Jangan mengunggah file `.env` ke repository.
3. Gunakan password database yang kuat.
4. Pastikan folder `writable/` memiliki permission yang sesuai.
5. Arahkan web server ke folder `public/`.
6. Aktifkan HTTPS pada server production.
7. Jangan menyimpan credential atau API key secara langsung di source code.
8. Lakukan backup database secara berkala.

---

## Development

Project dapat dikembangkan lebih lanjut dengan menambahkan modul baru melalui struktur CodeIgniter 4.

Contoh penambahan modul:

```text
Controller
    ↓
Model
    ↓
Database
    ↓
View
```

Untuk fitur yang membutuhkan pembatasan akses, gunakan Filter yang tersedia pada:

```text
app/Filters/
```

Saat ini repository memiliki filter untuk autentikasi dan administrator.

---

## Roadmap

Beberapa pengembangan yang dapat ditambahkan pada versi berikutnya:

* [ ] Laporan penjualan yang lebih lengkap
* [ ] Laporan laba dan rugi
* [ ] Export laporan Excel
* [ ] Dashboard dengan grafik interaktif
* [ ] Multi-cabang
* [ ] Role & permission yang lebih granular
* [ ] Audit log aktivitas pengguna
* [ ] Backup dan restore database
* [ ] API untuk integrasi aplikasi eksternal
* [ ] Progressive Web App (PWA)
* [ ] Integrasi pembayaran digital

---

## Contributing

Kontribusi terhadap project sangat terbuka.

### Fork repository

```bash
git fork https://github.com/yolanchndr/POS-APP
```

Buat branch baru:

```bash
git checkout -b feature/nama-fitur
```

Lakukan perubahan kemudian commit:

```bash
git add .
git commit -m "feat: add new feature"
```

Push branch:

```bash
git push origin feature/nama-fitur
```

Kemudian buat Pull Request melalui GitHub.

---

## Commit Convention

Untuk menjaga riwayat perubahan tetap mudah dibaca, gunakan format commit seperti:

```text
feat: menambahkan fitur baru
fix: memperbaiki bug transaksi
refactor: merapikan struktur kode
docs: memperbarui dokumentasi
style: memperbaiki tampilan
test: menambahkan pengujian
chore: perubahan konfigurasi
```

Contoh:

```bash
git commit -m "feat: add stock management"
```

---

## License

Project ini menggunakan lisensi **MIT**.

Lihat file [`LICENSE`](LICENSE) untuk informasi lengkap mengenai lisensi.

---

## Repository

Source code tersedia di:

**GitHub:**
https://github.com/yolanchndr/POS-APP

---

## Author

Developed by **yolanchndr**

Jika project ini bermanfaat, Anda dapat memberikan **Star** pada repository GitHub untuk mendukung pengembangan project.

---

<p align="center">
  <strong>POS-APP</strong><br>
  Point of Sale & Inventory Management System
</p>
