@extends('layouts.app')

@section('title', 'Transaksi Baru|ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Transaksi Baru</h1>
                            <p class="mt-2 text-emerald-100 text-lg">Pilih produk dan jumlah untuk checkout</p>
                        </div>

                        <a href="{{ route('transactions.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Search & Filter Section -->
                <div class="pl-8 pr-8 lg:pl-12 lg:pr-12 pt-8 lg:pt-12 pb-0">
                    <div class="mb-6 bg-emerald-50 rounded-xl shadow-sm p-6 border border-emerald-200">
                        <form method="GET" action="{{ route('transactions.create') }}" class="space-y-4">
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
                                        @foreach(\App\Models\Category::all() as $category)
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
                                <a href="{{ route('transactions.create') }}"
                                   class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="mx-8 lg:mx-12 mb-6 p-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                        <strong class="text-lg font-bold block mb-2">Error:</strong>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <div class="px-8 lg:px-12 pb-8 lg:pb-12">
                    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-10">
                        @csrf

                        <!-- Products Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-emerald-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Pilih</th>
                                        <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Nama Produk</th>
                                        <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Stok</th>
                                        <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($products as $index => $product)
                                        <tr class="hover:bg-emerald-50/50 transition-colors">
                                            <td class="px-6 py-5 text-center">
                                                <input type="checkbox"
                                                       name="items[{{ $index }}][selected]"
                                                       value="1"
                                                       {{ old("items.$index.selected") ? 'checked' : '' }}
                                                       class="h-5 w-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                                <input type="hidden"
                                                       name="items[{{ $index }}][product_id]"
                                                       value="{{ $product->id }}">
                                            </td>
                                            <td class="px-6 py-5 font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-6 py-5 text-gray-800">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-5 font-bold
                                                {{ $product->stock_quantity <= 5 ? 'text-red-600' : 
                                                   ($product->stock_quantity <= 10 ? 'text-orange-600' : 'text-emerald-700') }}">
                                                @php
                                                    $stock = rtrim(rtrim(number_format($product->stock_quantity, 3, '.', ''), '0'), '.');
                                                @endphp
                                                {{ $stock }} {{ $product->unit }}
                                            </td>
                                            <td class="px-6 py-5">
                                                @php
                                                    $isDecimal = in_array(strtolower($product->unit), ['kg', 'liter', 'l']);
                                                @endphp

                                                <input type="number"
                                                    name="items[{{ $index }}][quantity]"
                                                    value="{{ old("items.$index.quantity", $isDecimal ? 0.5 : 1) }}"
                                                    min="{{ $isDecimal ? 0.001 : 1 }}"
                                                    step="{{ $isDecimal ? 0.001 : 1 }}"
                                                    max="{{ $product->stock_quantity }}"
                                                    class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none text-center">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                                @if(request('search') || request('category_id'))
                                                    Tidak ditemukan produk yang sesuai dengan pencarian Anda.
                                                @else
                                                    Belum ada produk tersedia untuk transaksi.<br>
                                                    Tambahkan produk terlebih dahulu di halaman Produk.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-10 flex justify-end">
                            <button type="submit"
                                    class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                Checkout & Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection