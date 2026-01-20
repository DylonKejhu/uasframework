# ParamFresh: Laravel Web App

ParamFresh adalah sistem web untuk mendigitalisasi operasional toko yang menjual sayuran segar, bumbu dapur, bahan masakan, daging & makanan laut, serta minyak dan saus. Sistem ini dikembangkan untuk mengatasi pencatatan transaksi yang tidak terintegrasi dengan stok dan order brang, sehingga tujuan dibuatnya projek ini adalah untuk mempermudah pengelolaan inventaris yang lebih akurat.

Project ini dibangun menggunakan **Laravel 12**, **PHP 8.2** dan **Tailwind**, dengan database **MySQL**.

![Preview Dashboard](https://i.imgur.com/At0Ovv9.png)

## Kontributor

1. **Head & Back-end Developer (keju):** [DylonKejhu](https://github.com/DylonKejhu)
2. **Front-end Developer & UI/UX (eko):** [UrLords](https://github.com/UrLords)
3. **Supporters:** [nolaaa48](https://github.com/nolaaa48), [GrozyTons](https://github.com/GrozyTons)

## Milestone

### Fitur yang Dikerjakan

- ✅ **Authentication & Authorization**
  - ✅ Form Login
  - ✅ Role Management (Owner, Admin, User)
  - ✅ Middleware untuk proteksi route

- ✅ **CRUD Produk**
  - ✅ Form untuk tambah & edit produk
  - ✅ Tabel produk menampilkan: Nama, Kategori, Harga, Satuan, Stok
  
- ✅ **CRUD Kategori**
  - ✅ Form untuk tambah & edit kategori
  
- ✅ **CR Transaksi**
  - ✅ Form checkout dengan multi-select produk
  - ✅ Validasi stok otomatis
  - ✅ Pengurangan stok otomatis setelah transaksi
  - ✅ Perhitungan total harga otomatis
  - ✅ Tabel transaksi menampilkan: ID, Total Harga, Detail Items, Tanggal

- ✅ **CRU Orderan**
  - ✅ Tambah order pembelian ke supplier (multi-item)
  - ✅ Edit order selama status masih pending
  - ✅ Detail order (supplier, tanggal, catatan, item, subtotal)
  - ✅ Status order (pending / received)
  - ✅ Konfirmasi penerimaan order
  - ✅ Penambahan stok otomatis saat order diterima
  - ✅ Order terkunci setelah dikonfirmasi
  - ✅ Filter order berdasarkan tanggal
  
- ✅ **Seeder untuk data awal** (produk, kategori & user)

- ✅ **Search & Filter**
  - ✅ Pencarian produk tiap controller
  - ✅ Filter berdasarkan kategori
  - ✅ Filter transaksi berdasarkan tanggal

- ✅ **Dashboard**
  - ✅ Statistik penjualan
  - ✅ Managemen Produk
  - ✅ Managemen Kategori
  - ✅ Managemen Transaksi
  - ✅ Managemen Order

## Cara Setup Lokal

Pastikan sudah menginstall [php](https://www.youtube.com/watch?v=aNAJmCL_s9Y), [git](https://www.youtube.com/watch?v=uIjoN19McGU) dan [Composer](https://www.youtube.com/watch?v=15XYja-juSA) (Windows).  
Clone repo:

```bash
# syarat directory harus sudah ada di dalam folder htdocs
git clone https://github.com/DylonKejhu/uasframework.git
cd uasframework
composer install
```

Buat file .env

```bash
cp .env.example .env
php artisan key:generate
```

Atur file .env pada ~/uasframework/.env dan **BUAT** database di <http://127.0.0.1/phpmyadmin> dengan nama yang sama dan format utf8 general ci

```bash
#contoh yang digunakan dalam development kita
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paramadb
DB_USERNAME=root
DB_PASSWORD=
```

Migrasi dan Seed database:

```bash
php artisan migrate:fresh --seed
```

Jalankan server:

```bash
php artisan serve
```

Akses di: <http://127.0.0.1:8000>  
phpmyadmin diakses di <http://127.0.0.1/phpmyadmin>

## Workflow Git & Branch

Branch utama: main branch utama untuk dimerge  
Branch dev: keju (back-end), eko (front-end), romeo (UI/UX)  
Cara push branch masing - masing:

```bash
# masuk ke branch kalian
git checkout -f nama-branch-kalian
# Sesuaikan dengan nama file yang diubah saja
git add filepath/relatif
git commit -m "Deskripsi perubahan (wajib diisi)"
git push -u origin nama-branch-kalian

```

### Sebelum ingin merge, mohon hubungi admin terlebih dahulu  

## Struktur Database

### Users (untuk fitur authentication)

| Field             | Tipe      | Keterangan                    |
|-------------------|-----------|-------------------------------|
| id                | int       | Primary Key                   |
| name              | varchar   | Nama user                     |
| email             | varchar   | Email (unique)                |
| password          | varchar   | Password (hashed)             |
| role              | enum      | Role: admin, kasir            |
| email_verified_at | timestamp | Timestamp verifikasi email    |
| remember_token    | varchar   | Token remember me             |
| created_at        | timestamp | Timestamp created             |
| updated_at        | timestamp | Timestamp updated             |

### Categories

| Field      | Tipe      | Keterangan           |
|------------|-----------|----------------------|
| id         | int       | Primary Key          |
| name       | varchar   | Nama kategori        |
| slug       | varchar   | Slug kategori        |
| created_at | timestamp | Timestamp created    |
| updated_at | timestamp | Timestamp updated    |

### Products

| Field          | Tipe      | Keterangan                            |
|----------------|-----------|---------------------------------------|
| id             | int       | Primary Key                           |
| category_id    | int       | Foreign Key → categories.id           |
| name           | varchar   | Nama produk                           |
| slug           | varchar   | Slug produk                           |
| unit           | varchar   | Satuan (kg, ikat, biji, bungkus, dll) |
| price          | int       | Harga produk                          |
| stock_quantity | int       | Stok produk                           |
| created_at     | timestamp | Timestamp created                     |
| updated_at     | timestamp | Timestamp updated                     |

### Transactions

| Field       | Tipe      | Keterangan                    |
|-------------|-----------|-------------------------------|
| id          | int       | Primary Key                   |
| user_id     | int       | Foreign Key → users.id (null) |
| total_price | int       | Total harga transaksi         |
| created_at  | timestamp | Timestamp created             |
| updated_at  | timestamp | Timestamp updated             |

### Transaction Items

| Field          | Tipe      | Keterangan                        |
|----------------|-----------|-----------------------------------|
| id             | int       | Primary Key                       |
| transaction_id | int       | Foreign Key → transactions.id     |
| product_id     | int       | Foreign Key → products.id         |
| quantity       | int       | Jumlah produk                     |
| price          | int       | Harga satuan saat transaksi       |
| subtotal       | int       | Harga total (quantity × price)    |
| created_at     | timestamp | Timestamp created                 |
| updated_at     | timestamp | Timestamp updated                 |

## Data Seeder

### Kategori

1. Sayuran  
2. Bumbu Dapur  
3. Bahan Masakan  
4. Daging & Laut  
5. Minyak  
6. Saus & Bumbu  

### Produk

### 1. Sayuran

1.1 Bayam  
1.2 Kangkung  
1.3 Sawi  
1.4 Kol  
1.5 Kembang Kol  
1.6 Wortel  
1.7 Tomat  
1.8 Cabe Rawit  
1.9 Cabe Merah  
1.10 Cabe Hijau  
1.11 Buncis  
1.12 Pete  
1.13 Jengkol  
1.14 Selada  

### 2. Bumbu Dapur

2.1 Bawang Putih  
2.2 Bawang Merah  
2.3 Bawang Bombai  
2.4 Jahe  
2.5 Lengkuas  
2.6 Kunyit  
2.7 Kencur  
2.8 Garam Sunfish  

### 3. Bahan Masakan

3.1 Telur Ayam  
3.2 Tahu  
3.3 Tempe Besar  
3.4 Tempe Kecil  

### 4. Daging & Laut

4.1 Ayam Segar  
4.2 Ikan Asin  
4.3 Udang  

### 5. Minyak

5.1 Minyak Bimoli  
5.2 Minyak Filma  
5.3 Minyak Rose Brand Gelas  

### 6. Saus & Bumbu

6.1 Kecap Bango  
6.2 Kecap ABC  
6.3 Saos Tomat  
6.4 Masako Sapi  
6.5 Masako Ayam  
6.6 Bumbu Kuning  
6.7 Bumbu Kare  
6.8 Desaku Ketumbar  
6.9 Desaku Kunyit  
6.10 Desaku Cabe Bubuk  
6.11 Terasi ABC  
6.12 Sambal Terasi Uleg

## Teknologi yang Digunakan

- **Framework**: Laravel 12
- **PHP**: 8.2
- **Database**: MySQL
- **Frontend**: Blade Template Engine
- **Package Manager**: Composer

## License

This project is proprietary software.

Free for personal, educational, and other non-commercial use only.
Commercial use, redistribution, and reuse of original branding are prohibited.
Attribution with a link to the original project is required.

See the [LICENSE](LICENSE) file for full terms.
