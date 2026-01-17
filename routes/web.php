<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;


Route::get('/', function () {
    return view('welcome', [
        'products' => Product::with('category')->get(),
        'categories' => Category::all(),
    ]);
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

#tidak full resource utk transaksi (modifikasi struk itu berbahaya)
Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store']);