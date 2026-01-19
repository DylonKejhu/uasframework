<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Order;
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
        $totalOrders = Order::count();
        
        // === FITUR KEUANGAN BARU ===
        
        // Pendapatan Kotor (Total dari semua transaksi)
        $grossRevenue = Transaction::sum('total_price');
        
        // Total Pengeluaran (Total biaya dari orders yang sudah diterima)
        $totalExpenses = Order::where('status', 'received')->sum('total_cost');
        
        // Pendapatan Bersih (Pendapatan Kotor - Pengeluaran)
        $netRevenue = $grossRevenue - $totalExpenses;
        
        // Margin Keuntungan (%)
        $profitMargin = $grossRevenue > 0 ? ($netRevenue / $grossRevenue) * 100 : 0;
        
        // === STATISTIK PERIODE (7 HARI TERAKHIR) ===
        
        // Pendapatan 7 hari terakhir
        $weeklyRevenue = Transaction::where('created_at', '>=', now()->subDays(7))
            ->sum('total_price');
        
        // Pengeluaran 7 hari terakhir
        $weeklyExpenses = Order::where('status', 'received')
            ->where('updated_at', '>=', now()->subDays(7))
            ->sum('total_cost');
        
        // Pendapatan bersih 7 hari terakhir
        $weeklyNetRevenue = $weeklyRevenue - $weeklyExpenses;
        
        // === STATISTIK BULAN INI ===
        
        // Pendapatan bulan ini
        $monthlyRevenue = Transaction::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        
        // Pengeluaran bulan ini
        $monthlyExpenses = Order::where('status', 'received')
            ->whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->sum('total_cost');
        
        // Pendapatan bersih bulan ini
        $monthlyNetRevenue = $monthlyRevenue - $monthlyExpenses;
        
        // === DATA YANG SUDAH ADA SEBELUMNYA ===
        
        // Produk dengan stok menipis (stok <= 5, sesuai dengan logic di blade)
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->get();
        
        // Produk Terlaris (berdasarkan total quantity terjual)
        $bestSellingProducts = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('CAST(SUM(transaction_items.quantity) AS DECIMAL(10,3)) as total_sold')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Transaksi Terbaru (5 terakhir)
        $recentTransactions = Transaction::with(['items.product'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Orderan Terbaru (5 terakhir)
        $recentOrders = Order::with(['items.product'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Data untuk grafik transaksi & keuangan (7 hari terakhir)
        $transactionChart = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Data pengeluaran per hari (7 hari terakhir) untuk ditambahkan ke chart
        $expenseChart = DB::table('orders')
            ->selectRaw('DATE(updated_at) as date')
            ->selectRaw('SUM(total_cost) as expenses')
            ->where('status', 'received')
            ->where('updated_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Gabungkan data revenue dan expenses untuk chart
        $financialChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            $transaction = $transactionChart->firstWhere('date', $date);
            $expense = $expenseChart->firstWhere('date', $date);
            
            $revenue = $transaction ? $transaction->revenue : 0;
            $expenses = $expense ? $expense->expenses : 0;
            
            $financialChart[] = (object)[
                'date' => $date,
                'total' => $transaction ? $transaction->total : 0,
                'revenue' => $revenue,
                'expenses' => $expenses,
                'net_revenue' => $revenue - $expenses
            ];
        }
        
        // === QUERY PRODUK DENGAN SEARCH & FILTER ===
        
        $productsQuery = Product::with('category');
        
        // Search produk
        if ($request->has('search') && $request->search != '') {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('category_id', $request->category_id);
        }
        
        // Pagination
        $products = $productsQuery->simplePaginate(10);
        
        // Append query string ke pagination
        $products->appends($request->all());
        
        $categories = Category::all();
        
        return view('dashboard.index', compact(
            // Data Produk & Kategori
            'totalProducts',
            'totalCategories',
            'products',
            'categories',
            'lowStockProducts',
            'bestSellingProducts',
            
            // Data Transaksi & Orders
            'totalTransactions',
            'totalOrders',
            'recentTransactions',
            'recentOrders',
            
            // Data Keuangan Keseluruhan
            'grossRevenue',
            'totalExpenses',
            'netRevenue',
            'profitMargin',
            
            // Data Keuangan Periode
            'weeklyRevenue',
            'weeklyExpenses',
            'weeklyNetRevenue',
            'monthlyRevenue',
            'monthlyExpenses',
            'monthlyNetRevenue',
            
            // Data Chart
            'transactionChart',
            'financialChart'
        ));
    }
}