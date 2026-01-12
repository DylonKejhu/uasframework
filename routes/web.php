<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;



Route::get('/', function () {
    return view('welcome', [
        'products' => Product::with('category')->get(),
        'categories' => Category::all(),
    ]);
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);