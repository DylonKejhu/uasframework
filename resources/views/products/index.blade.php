@extends('layouts.app')

@section('title', 'Daftar Produk|ParamaFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-4 mb-10">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Produk</h1>
                        <p class="text-emerald-700 mt-2">Kelola stok sayuran, bumbu, daging & bahan segar Anda</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <!-- Tambah Produk -->
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Produk Baru
                        </a>
                    </div>
                </div>

                <!-- Search & Filter Section -->
                <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-emerald-100">
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
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
                            <a href="{{ route('products.index') }}"
                               class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Main Table Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-emerald-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Satuan</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Stok</th>
                                    <th class="px-6 py-5 text-center text-sm font-semibold text-emerald-800 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($products as $i => $product)
                                <tr class="hover:bg-emerald-50 transition-colors duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
                                    <td class="px-6 py-5 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-5 text-sm text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                                    <td class="px-6 py-5 text-sm font-medium text-gray-800">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600">{{ $product->unit }}</td>
                                    <td class="px-6 py-5 text-sm font-bold
                                        {{ $product->stock_quantity <= 5 ? 'text-red-600' : 
                                           ($product->stock_quantity <= 10 ? 'text-orange-600' : 'text-emerald-700') }}">
                                        @php
                                            $stock = rtrim(rtrim(number_format($product->stock_quantity, 3, '.', ''), '0'), '.');
                                        @endphp
                                        {{ $stock }} {{ $product->unit }}
                                    </td>
                                    <td class="px-6 py-5 text-center text-sm">
                                        <div class="flex items-center justify-center gap-5">
                                            <!-- Edit Button -->
                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="inline-flex items-center px-5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium rounded-lg transition border border-indigo-200 hover:border-indigo-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Hapus Button -->
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin hapus produk ini?')"
                                                        class="inline-flex items-center px-5 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition border border-red-200 hover:border-red-300">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                            @if(request('search') || request('category_id'))
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ditemukan produk yang sesuai dengan pencarian</p>
                                                <p class="text-sm mt-2">Coba ubah kata kunci pencarian atau filter kategori</p>
                                            @else
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada produk terdaftar</p>
                                                <p class="text-sm mt-2">Klik tombol "Tambah Produk Baru" untuk menambahkan produk pertama Anda</p>
                                            @endif
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