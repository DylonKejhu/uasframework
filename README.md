# ParamFresh: Laravel Web App

<div style="text-align: justify;">
ParamFresh adalah sistem web untuk mendigitalisasi operasional toko yang menjual sayuran segar, bumbu dapur, bahan masakan, daging & makanan laut, serta minyak dan saus. Sistem ini dikembangkan untuk mengatasi pencatatan transaksi yang tidak terintegrasi dengan stok, sehingga mempermudah pengelolaan inventaris yang lebih akurat.

Project ini dibangun menggunakan <strong>Laravel 12</strong> dan <strong>PHP 8.2</strong>, dengan database MySQL.
</div>

## Pembagian Tugas

1. Back-end Developers (keju): [DylonKejhu](https://github.com/DylonKejhu),
2. Front-end Developers (eko): [UrLords](https://github.com/UrLords),
3. UI/UX (romeo): [nolaaa48](https://github.com/nolaaa48), Evan, [bimodwikusumo](https://github.com/bimodwikusumo), [gustianidwi22-dotcom](https://github.com/gustianidwi22-dotcom)

## Fitur

1. CRUD Produk
2. CRUD Kategori
3. Seeder untuk data awal (produk & kategori)
4. Tabel produk menampilkan:
    - Nama Produk
    - Kategori
    - Harga
    - Satuan
    - Stok
5. Form barebone untuk tambah & edit produk/kategori

## Cara Setup Lokal

Pastikan sudah menginstall [php](https://www.youtube.com/watch?v=aNAJmCL_s9Y) dan [Composer](https://www.youtube.com/watch?v=15XYja-juSA).  
Clone repo:

```bash
# syarat pointer harus sudah ada di dalam folder htdocs
git clone https://github.com/DylonKejhu/uasframework.git
cd uasframework
```

Buat file .env

```bash
cp .env.example .env
php artisan key:generate
```

Atur file .env pada ~/uasframework/.env sesuai dengan nama database yang ingin dibuat ketika menjalankan perintah selanjutnya

```bash
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={namadatabase} <----- mohon diubah namanya
DB_USERNAME=root
DB_PASSWORD=
```

Migrasi dan seed database:

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

Branch utama: main branch utama untuk setelah dimerge  
Branch dev: keju, eko, romeo  
Cara push branch baru:

```bash
# masuk ke branch kalian
git checkout -b nama-branch-kalian
# Sesuaikan dengan nama file yang diubah saja
git add filepath/relatif
git commit -m "Deskripsi perubahan (wajib diisi)"
git push -u origin nama-branch-kalian

```

### Sebelum ingin merge, mohon hubungi admin terlebih dahulu.

## Struktur Database

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
