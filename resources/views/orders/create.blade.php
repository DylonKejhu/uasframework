@extends('layouts.app')

@section('title', 'Order Baru - ParamaFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Order Baru</h1>
                            <p class="mt-2 text-emerald-100 text-lg">Buat order pembelian stok dari supplier</p>
                        </div>

                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="mx-8 lg:mx-12 mt-8 mb-6 p-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <strong class="text-lg font-bold block mb-2">Terjadi Kesalahan:</strong>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Search & Filter Section (Outside Form) -->
                <div class="mx-8 lg:mx-12 mt-8 bg-white rounded-xl shadow-sm p-5 border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari & Filter Produk
                    </h3>
                    <form method="GET" action="{{ route('orders.create') }}" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Search Input -->
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari nama produk..." 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <select name="category_id"
                                        class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
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
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium text-sm">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('orders.create') }}"
                               class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Main Order Form -->
                <div class="px-8 lg:px-12 pb-8 lg:pb-12">
                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Informasi Supplier -->
                        <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200 mt-8">
                            <h2 class="text-xl font-bold text-emerald-800 mb-4">Informasi Supplier</h2>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Nama Supplier -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Supplier <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="supplier_name" 
                                           value="{{ old('supplier_name') }}"
                                           required
                                           placeholder="Masukkan nama supplier"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" 
                                              rows="2"
                                              placeholder="Tambahkan catatan untuk order ini..."
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div>
                            <h2 class="text-lg font-bold text-emerald-800 mb-4">Pilih Produk untuk Order</h2>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden border border-gray-200">
                                    <thead class="bg-emerald-50">
                                        <tr>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider w-20">Pilih</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Kategori</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Stok Saat Ini</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider w-32">Jumlah Order</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider w-48">Harga/Unit</th>
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
                                                <td class="px-6 py-5">
                                                    <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                                    <span class="block text-xs text-gray-500 mt-1">{{ $product->unit }}</span>
                                                </td>
                                                <td class="px-6 py-5 text-sm text-gray-600">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $product->category?->name ?? 'Tanpa Kategori' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-sm font-bold
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
                                                        value="{{ old("items.$index.quantity", $isDecimal ? 1 : 1) }}"
                                                        min="{{ $isDecimal ? 0.001 : 1 }}"
                                                        step="{{ $isDecimal ? 0.001 : 1 }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none text-center">
                                                </td>
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center">
                                                        <span class="mr-2 text-gray-600 text-sm">Rp</span>
                                                        <input type="number"
                                                            name="items[{{ $index }}][cost_per_unit]"
                                                            value="{{ old("items.$index.cost_per_unit", 0) }}"
                                                            min="0"
                                                            step="0.01"
                                                            placeholder="0"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                    @if(request('search') || request('category_id'))
                                                        <p class="text-lg font-medium">Tidak ditemukan produk yang sesuai dengan pencarian</p>
                                                        <p class="text-sm mt-2">Coba ubah kata kunci atau filter kategori</p>
                                                    @else
                                                        <p class="text-lg font-medium">Belum ada produk tersedia untuk order</p>
                                                        <p class="text-sm mt-2">Tambahkan produk terlebih dahulu di halaman Produk</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- @if($products->count() > 0)
                            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-r flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold mb-2">Petunjuk Penggunaan:</p>
                                    <ul class="text-sm space-y-1">
                                        <li>✓ Centang produk yang ingin dipesan</li>
                                        <li>✓ Atur jumlah order dan harga per unit</li>
                                        <li>✓ Order akan berstatus "Pending" sampai dikonfirmasi diterima</li>
                                        <li>✓ Stok produk akan ditambahkan setelah konfirmasi</li>
                                    </ul>
                                </div>
                            </div>
                            @endif -->
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 flex flex-col sm:flex-row gap-4 justify-end border-t border-gray-200">
                            <a href="{{ route('orders.index') }}"
                               class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 text-lg font-medium rounded-xl shadow-md transition-all duration-300 text-center">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection