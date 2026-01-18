@extends('layouts.app')

@section('title', 'Dashboard - ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header -->
                <header class="mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Dashboard ParamFresh</h1>
                    <p class="text-emerald-700 mt-2">Kelola stok & transaksi toko sayur segar Anda</p>
                </header>

                <!-- Category Filter -->
                <div class="mb-8 max-w-xs">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
                    <select 
                        onchange="window.location.href = this.value"
                        class="w-full px-4 py-3 bg-white border border-emerald-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                        <option value="{{ route('dashboard') }}" {{ !request('category_id') ? 'selected' : '' }}>
                            Semua Kategori
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ route('dashboard', ['category_id' => $category->id]) }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-10 flex flex-col sm:flex-row gap-4">
                    @if(request('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama produk..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Cari
                        </button>
                        <a href="{{ route('dashboard', request()->only('category_id')) }}"
                           class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Reset
                        </a>
                    </div>
                </form>

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
                                            {{ $product->stock_quantity }}
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
                        <h3 class="text-lg font-semibold text-emerald-800">Total Pendapatan</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
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
                                            <td class="px-6 py-4 font-bold text-red-700">{{ $product->stock_quantity }}</td>
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
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $product->total_sold }} pcs</td>
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

                <!-- Transaction History (Last 7 Days) -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-emerald-100">
                    <h2 class="text-2xl font-bold text-emerald-900 mb-6">Riwayat Transaksi (7 Hari Terakhir)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Jumlah Transaksi</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-800">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transactionChart as $chart)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ date('d/m/Y', strtotime($chart->date)) }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $chart->total }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                            Rp {{ number_format($chart->revenue, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 italic">
                                            Belum ada data transaksi 7 hari terakhir
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