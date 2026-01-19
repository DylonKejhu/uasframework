<?php
#Laravel 12 stuff (gda di materi)
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderController;



// Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
// Category Routes (Full Resource)
Route::resource('categories', CategoryController::class);
// Product Routes (Full Resource)
Route::resource('products', ProductController::class);
// Transaction Routes (Tidak full resource karena modifikasi struk ity berbahaya)
Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store']);
// Order Routes (Tidak full resource karena destroy order ity berbahaya)
Route::resource('orders', OrderController::class)->except(['destroy']);