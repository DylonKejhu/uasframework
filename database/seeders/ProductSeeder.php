<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn ($name) => Category::where('name', $name)->firstOrFail()->id;

        $products = [
            // ======================
            // SAYURAN
            // ======================
            ['Sayuran', 'Bayam', 'ikat', 3000],
            ['Sayuran', 'Kangkung', 'ikat', 3000],
            ['Sayuran', 'Sawi', 'ikat', 4000],
            ['Sayuran', 'Kol', 'ikat', 5000],
            ['Sayuran', 'Kembang Kol', 'kg', 14000],
            ['Sayuran', 'Wortel', 'kg', 12000],
            ['Sayuran', 'Tomat', 'kg', 8000],
            ['Sayuran', 'Cabe Rawit', 'kg', 70000],
            ['Sayuran', 'Cabe Merah', 'kg', 55000],
            ['Sayuran', 'Cabe Hijau', 'kg', 45000],
            ['Sayuran', 'Buncis', 'kg', 10000],
            ['Sayuran', 'Pete', 'ikat', 8000],
            ['Sayuran', 'Jengkol', 'kg', 18000],
            ['Sayuran', 'Selada', 'ikat', 6000],

            // ======================
            // BUMBU DAPUR
            // ======================
            ['Bumbu Dapur', 'Bawang Putih', 'kg', 32000],
            ['Bumbu Dapur', 'Bawang Merah', 'kg', 38000],
            ['Bumbu Dapur', 'Bawang Bombai', 'biji', 6000],
            ['Bumbu Dapur', 'Jahe', 'kg', 25000],
            ['Bumbu Dapur', 'Lengkuas', 'kg', 22000],
            ['Bumbu Dapur', 'Kunyit', 'kg', 20000],
            ['Bumbu Dapur', 'Kencur', 'kg', 24000],
            ['Bumbu Dapur', 'Garam Sunfish', 'bungkus', 3000],

            // ======================
            // BAHAN MASAKAN
            // ======================
            ['Bahan Masakan', 'Telur Ayam', 'kg', 28000],
            ['Bahan Masakan', 'Tahu', 'bungkus', 5000],
            ['Bahan Masakan', 'Tempe Kecil', 'bungkus', 4000],
            ['Bahan Masakan', 'Tempe Besar', 'bungkus', 7000],

            // ======================
            // DAGING & LAUT
            // ======================
            ['Daging & Laut', 'Ayam Segar', 'kg', 38000],
            ['Daging & Laut', 'Ikan Asin', 'kg', 45000],
            ['Daging & Laut', 'Udang', 'kg', 65000],

            // ======================
            // MINYAK
            // ======================
            ['Minyak', 'Minyak Bimoli', 'liter', 16000],
            ['Minyak', 'Minyak Filma', 'liter', 15000],
            ['Minyak', 'Minyak Rose Brand Gelas', 'gelas', 6000],

            // ======================
            // SAUS & BUMBU
            // ======================
            ['Saus & Bumbu', 'Kecap Bango 275ml', 'botol', 15000],
            ['Saus & Bumbu', 'Kecap ABC 100ml', 'botol', 7000],
            ['Saus & Bumbu', 'Saos Tomat Sachet 1kg', 'bungkus', 12000],
            ['Saus & Bumbu', 'Masako Sapi', 'sachet', 1000],
            ['Saus & Bumbu', 'Masako Ayam', 'sachet', 1000],
            ['Saus & Bumbu', 'Bumbu Kuning', 'sachet', 2000],
            ['Saus & Bumbu', 'Bumbu Kare', 'sachet', 2000],
            ['Saus & Bumbu', 'Desaku Ketumbar', 'sachet', 1500],
            ['Saus & Bumbu', 'Desaku Kunyit', 'sachet', 1500],
            ['Saus & Bumbu', 'Desaku Cabe Bubuk', 'sachet', 1500],
            ['Saus & Bumbu', 'Terasi ABC 5g', 'sachet', 1000],
            ['Saus & Bumbu', 'Sambal Terasi Uleg 15g', 'sachet', 2000],
        ];

        foreach ($products as [$category, $name, $unit, $price]) {
            # vb utk tipe unit yg berbeda
            $stockQuantity = match ($unit) {
                'kg'     => fake()->randomFloat(3, 0.5, 10),
                'liter'  => fake()->randomFloat(3, 1, 30),
                default  => random_int(10, 100),
            };

            Product::create([
                'category_id'    => $cat($category),
                'name'           => $name,
                'slug'           => Str::slug($name),
                'unit'           => $unit,
                'price'          => $price,
                'stock_quantity' => $stockQuantity,
                'is_active'      => true,
            ]);
        }
    }
}
