@extends('layouts.app')

@section('title', 'Dashboard|ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header -->
                <header class="mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Dashboard ParamFresh</h1>
                    <p class="text-emerald-700 mt-2">Kelola stok & transaksi toko sayur segar Anda</p>
                </header>

                <!-- === STATISTIK KEUANGAN UTAMA === -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Pendapatan Kotor -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg text-white">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium opacity-90">Pendapatan Kotor</h3>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold mb-1">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</p>
                        <p class="text-xs opacity-75">Total penjualan</p>
                    </div>

                    <!-- Total Pengeluaran -->
                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 rounded-xl shadow-lg text-white">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium opacity-90">Total Pengeluaran</h3>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold mb-1">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                        <p class="text-xs opacity-75">Biaya pembelian stok</p>
                    </div>

                    <!-- Pendapatan Bersih -->
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 rounded-xl shadow-lg text-white">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium opacity-90">Pendapatan Bersih</h3>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold mb-1">Rp {{ number_format($netRevenue, 0, ',', '.') }}</p>
                        <p class="text-xs opacity-75">Keuntungan aktual</p>
                    </div>

                    <!-- Margin Keuntungan -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-xl shadow-lg text-white">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium opacity-90">Margin Keuntungan</h3>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold mb-1">{{ number_format($profitMargin, 1) }}%</p>
                        <p class="text-xs opacity-75">Rasio keuntungan</p>
                    </div>
                </div>

                <!-- === STATISTIK PERIODE === -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <!-- 7 Hari Terakhir -->
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            7 Hari Terakhir
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-sm text-gray-700">Pendapatan Kotor</span>
                                <span class="font-bold text-blue-600">Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                <span class="text-sm text-gray-700">Pengeluaran</span>
                                <span class="font-bold text-red-600">Rp {{ number_format($weeklyExpenses, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg border-2 border-emerald-200">
                                <span class="text-sm font-semibold text-gray-800">Pendapatan Bersih</span>
                                <span class="font-bold text-emerald-700">Rp {{ number_format($weeklyNetRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bulan Ini -->
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Bulan Ini ({{ now()->format('F Y') }})
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-sm text-gray-700">Pendapatan Kotor</span>
                                <span class="font-bold text-blue-600">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                <span class="text-sm text-gray-700">Pengeluaran</span>
                                <span class="font-bold text-red-600">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg border-2 border-emerald-200">
                                <span class="text-sm font-semibold text-gray-800">Pendapatan Bersih</span>
                                <span class="font-bold text-emerald-700">Rp {{ number_format($monthlyNetRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Section -->
                <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-emerald-100">
                    <form method="GET" action="{{ route('dashboard') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search Input -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari nama produk..." 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
                                <select name="category_id"
                                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('dashboard') }}"
                               class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Products Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-emerald-100 mb-12">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">No</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Nama Produk</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Kategori</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Harga</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Satuan</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Stok</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-emerald-800">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($products as $index => $product)
                                    <tr class="hover:bg-emerald-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->unit }}</td>
                                        <td class="px-6 py-4 text-sm font-bold
                                            {{ $product->stock_quantity <= 5 ? 'text-red-600' : 'text-emerald-700' }}">
                                            @php
                                                $stock = rtrim(rtrim(number_format($product->stock_quantity, 3, '.', ''), '0'), '.');
                                            @endphp
                                            {{ $stock }} {{ $product->unit }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center text-gray-500 italic">
                                            @if(request('search')) Tidak ditemukan produk dengan pencarian ini
                                            @elseif(request('category_id')) Tidak ada produk di kategori ini
                                            @else Belum ada produk @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-emerald-50 border-t">
                        {{ $products->links() }}
                    </div>
                </div>

                <!-- Tambah Produk Button -->
                <div class="mb-12">
                    <a href="{{ route('products.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Produk Baru
                    </a>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-semibold text-emerald-800">Total Produk</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalProducts }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-semibold text-emerald-800">Total Kategori</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalCategories }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-semibold text-emerald-800">Total Transaksi</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalTransactions }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-emerald-100">
                        <h3 class="text-lg font-semibold text-emerald-800">Total Orderan</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalOrders ?? 0 }}</p>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                @if($lowStockProducts->count() > 0)
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-xl mb-12">
                        <h2 class="text-xl font-bold text-red-800 mb-4">
                            ⚠️ Peringatan: {{ $lowStockProducts->count() }} Produk Stok Menipis!
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-red-200">
                                <thead class="bg-red-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-red-800">Nama Produk</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-red-800">Kategori</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-red-800">Stok</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-red-800">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-red-100">
                                    @foreach($lowStockProducts as $product)
                                        <tr>
                                            <td class="px-6 py-4">{{ $product->name }}</td>
                                            <td class="px-6 py-4">{{ $product->category->name }}</td>
                                            <td class="px-6 py-4 font-bold text-red-700">
                                                @php
                                                    $stock = rtrim(rtrim(number_format($product->stock_quantity, 3, '.', ''), '0'), '.');
                                                @endphp
                                                {{ $stock }}
                                            </td>
                                            <td class="px-6 py-4">{{ $product->unit }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Best Selling Products -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-12 border border-emerald-100">
                    <h2 class="text-2xl font-bold text-emerald-900 mb-6">Produk Terlaris</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">No</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Nama Produk</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Total Terjual</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($bestSellingProducts as $index => $product)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                            @php
                                                $qty = rtrim(rtrim(number_format($product->total_sold, 3, '.', ''), '0'), '.');
                                            @endphp
                                            {{ $qty }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 italic">
                                            Belum ada data penjualan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-12 border border-emerald-100">
                    <h2 class="text-2xl font-bold text-emerald-900 mb-6">Transaksi Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">ID</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Total Harga</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 italic">
                                            Belum ada transaksi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('transactions.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Lihat Semua Transaksi
                        </a>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-12 border border-emerald-100">
                    <h2 class="text-2xl font-bold text-emerald-900 mb-6">Orderan Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">ID</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Supplier</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Total Biaya</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Status</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->supplier_name }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                            Rp {{ number_format($order->total_cost, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($order->status === 'received')
                                                <span class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 text-xs font-semibold rounded-full">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                            Belum ada orderan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Lihat Semua Orderan
                        </a>
                    </div>
                </div>

                <!-- Financial History (Last 7 Days) -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-emerald-100">
                    <h2 class="text-2xl font-bold text-emerald-900 mb-6">Riwayat Keuangan (7 Hari Terakhir)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Jumlah Transaksi</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Pendapatan</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Pengeluaran</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Keuntungan Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($financialChart as $chart)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ date('d/m/Y', strtotime($chart->date)) }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $chart->total }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                            Rp {{ number_format($chart->revenue, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-red-600">
                                            Rp {{ number_format($chart->expenses, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold {{ $chart->net_revenue >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            Rp {{ number_format($chart->net_revenue, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                            Belum ada data keuangan 7 hari terakhir
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection