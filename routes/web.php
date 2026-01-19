<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Routes (All authenticated users)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Transaction & Order Routes (All authenticated users can access)
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store']);
    Route::resource('orders', OrderController::class)->except(['destroy']);
    
    // Owner & Admin Routes (Products, Categories)
    Route::middleware(['role:owner,admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });
    
    // User Management Routes (Owner & Admin can access)
    Route::middleware(['role:owner,admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});