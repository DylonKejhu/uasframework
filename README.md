# ParamaFresh - Laravel Web App

ParamaFresh adalah sistem web untuk toko online yang menjual sayuran segar, bumbu dapur, bahan masakan, daging & makanan laut, minyak, serta saus & bumbu.  
Project ini dibuat menggunakan **Laravel 12** dan **PHP 8.2**, dengan database MySQL.

## Fitur

- CRUD Produk
- CRUD Kategori
- Seeder untuk data awal (produk & kategori)
- Tabel produk menampilkan:
  - Nama Produk
  - Kategori
  - Harga
  - Satuan
  - Stok
- Form barebone untuk tambah & edit produk/kategori
- Relasi **Produk → Kategori**

## Struktur Database

### Categories

| Field      | Tipe      | Keterangan           |
|------------|-----------|----------------------|
| id         | bigint    | Primary Key          |
| name       | varchar   | Nama kategori        |
| slug       | varchar   | Slug kategori        |
| created_at | timestamp | Timestamp created    |
| updated_at | timestamp | Timestamp updated    |

### Products

| Field          | Tipe      | Keterangan                            |
|----------------|-----------|---------------------------------------|
| id             | bigint    | Primary Key                           |
| category_id    | bigint    | Foreign Key → categories.id           |
| name           | varchar   | Nama produk                           |
| slug           | varchar   | Slug produk                           |
| unit           | varchar   | Satuan (kg, ikat, biji, bungkus, dll) |
| price          | integer   | Harga produk                          |
| stock_quantity | integer   | Stok produk                           |
| created_at     | timestamp | Timestamp created                     |
| updated_at     | timestamp | Timestamp updated                     |

## Data Seeder

### Kategori

- Sayuran  
- Bumbu Dapur  
- Bahan Masakan  
- Daging & Laut  
- Minyak  
- Saus & Bumbu  

### Produk

**Sayuran:** Bayam, Kangkung, Sawi, Kol, Kembang Kol, Wortel, Tomat, Cabe Rawit, Cabe Merah, Cabe Hijau, Buncis, Pete, Jengkol, Selada  

**Bumbu Dapur:** Bawang Putih, Bawang Merah, Bawang Bombai, Jahe, Lengkuas, Kunyit, Kencur, Garam Sunfish  

**Bahan Masakan:** Telur Ayam, Tahu, Tempe Besar, Tempe Kecil  

**Daging & Laut:** Ayam Segar, Ikan Asin, Udang  

**Minyak:** Minyak Bimoli, Minyak Filma, Minyak Rose Brand Gelas  

**Saus & Bumbu:** Kecap Bango, Kecap ABC, Saos Tomat, Masako Sapi, Masako Ayam, Bumbu Kuning, Bumbu Kare, Desaku Ketumbar, Desaku Kunyit, Desaku Cabe Bubuk, Terasi ABC, Sambal Terasi Uleg  

## Cara Setup Lokal

- Clone repo:

```bash
git clone https://github.com/DylonKejhu/uasframework.git
cd uasframework
```

- Install composer kalau belum:

```bash
composer install
```

- Buat file .env

```bash
cp .env.example .env
php artisan key:generate
```

Atur database di .env sesuai lokal (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)

- Migrasi dan seed database:

```bash
php artisan migrate:fresh --seed
```

- Jalankan server:

```bash
php artisan serve
```

Akses di: <http://127.0.0.1:8000>

## Workflow Git & Branch

- Branch utama: main → branch utama untuk setelah dimerge
- Branch dev: keju,1,2,3,4 → branch kalian
- Cara push branch baru:

```bash
# masuk ke branch kalian
git checkout -b nama-branch-kalian
# buat perubahan
git add .
git commit -m "Deskripsi perubahan (wajib diisi)"
git push -u origin nama-branch-kalian

```

- Merge ke main:
Sebelum ingin merge mohon hubungi admin terlebih dahulu
