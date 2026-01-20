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
    
    // Redirect root based on role
    Route::get('/', function () {
        if (auth()->user()->canAccessOwnerFeatures()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('transactions.index');
    });
    
    // Transaction Routes (All authenticated users can access)
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store']);
    
    // Owner & Admin Only Routes
    Route::middleware(['role:owner,admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Categories & Products
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        
        // Orders
        Route::resource('orders', OrderController::class)->except(['destroy']);
        
        // User Management
        Route::resource('users', UserController::class);
    });
});