@extends('layouts.app')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Edit Produk</h1>
                            <p class="mt-2 text-emerald-100 text-lg font-medium">{{ $product->name }}</p>
                        </div>

                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8 lg:p-12">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Nama Produk -->
                        <div class="space-y-2">
                            <label for="name" class="block text-lg font-medium text-gray-800">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $product->name) }}" required
                                   class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-lg shadow-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-lg font-medium text-gray-800">Kategori</label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white text-lg shadow-sm transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga, Satuan, Stok -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label for="price" class="block text-lg font-medium text-gray-800">Harga (Rp)</label>
                                <input type="number" name="price" id="price"
                                       value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-lg shadow-sm transition-all">
                                @error('price')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="unit" class="block text-lg font-medium text-gray-800">Satuan</label>
                                <input type="text" name="unit" id="unit" list="unit-options"
                                       value="{{ old('unit', $product->unit) }}" required
                                       placeholder="Pilih atau ketik baru"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-lg shadow-sm transition-all">
                                <datalist id="unit-options">
                                    @php
                                        $existingUnits = \App\Models\Product::select('unit')->distinct()->orderBy('unit')->pluck('unit');
                                    @endphp
                                    @foreach($existingUnits as $existingUnit)
                                        <option value="{{ $existingUnit }}">
                                    @endforeach
                                </datalist>
                                @error('unit')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="stock_quantity" class="block text-lg font-medium text-gray-800">Stok</label>
                                <input type="number" name="stock_quantity" id="stock_quantity"
                                       value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0" step="0.001"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-lg shadow-sm transition-all">
                                @error('stock_quantity')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8 flex justify-end">
                            <button type="submit"
                                    class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection