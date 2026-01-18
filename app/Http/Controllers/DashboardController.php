<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Statistik Umum
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_price');
        
        // Produk dengan stok menipis (stok < 10)
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->get();
        
        // Produk Terlaris (berdasarkan total quantity terjual)
        $bestSellingProducts = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(transaction_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Transaksi Terbaru (5 terakhir)
        $recentTransactions = Transaction::with(['items.product'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Data untuk grafik transaksi (7 hari terakhir)
        $transactionChart = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Query untuk tabel produk dengan search & filter
        $productsQuery = Product::with('category');
        
        // Search produk
        if ($request->has('search') && $request->search != '') {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter kategori (dari sidebar utk view dashboard fitur request dari kamu)
        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('category_id', $request->category_id);
        }
        
        /**
        * simplePaginate untuk pagination yang lebih sederhana, 
        * kalau pake fungsi Paginate() juga bisa tapi dia pake bootstrap
        */
        $products = $productsQuery->simplePaginate(10);
        
        // Append query string ke pagination
        $products->appends($request->all());
        
        $categories = Category::all();
        
        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories', 
            'totalTransactions',
            'totalRevenue',
            'lowStockProducts',
            'bestSellingProducts',
            'recentTransactions',
            'transactionChart',
            'products',
            'categories'
        ));
    }
}