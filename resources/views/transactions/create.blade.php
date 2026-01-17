@extends('layouts.app')

@section('title', 'Transaksi Baru - ParamFresh')

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

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="m-8 p-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                        <strong class="text-lg font-bold block mb-2">Error:</strong>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <div class="p-8 lg:p-12">
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
                                            <td class="px-6 py-5 text-gray-700">{{ $product->stock_quantity }}</td>
                                            <td class="px-6 py-5">
                                                <input type="number"
                                                       name="items[{{ $index }}][quantity]"
                                                       value="{{ old("items.$index.quantity", 1) }}"
                                                       min="1"
                                                       max="{{ $product->stock_quantity }}"
                                                       class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none text-center">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                                Belum ada produk tersedia untuk transaksi.<br>
                                                Tambahkan produk terlebih dahulu di halaman Produk.
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