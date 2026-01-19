@extends('layouts.app')

@section('title', 'Edit Order|ParamaFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Edit Order</h1>
                            <p class="mt-2 text-emerald-100 text-lg">Perbarui informasi order dari supplier</p>
                            <div class="mt-3 inline-flex items-center px-4 py-2 bg-orange-500/20 border border-orange-300 rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">Status: Pending</span>
                            </div>
                        </div>

                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="mx-8 lg:mx-12 mt-8 mb-4 p-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
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

                <!-- Form -->
                <div class="p-8 lg:p-12">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Supplier -->
                        <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                            <h2 class="text-xl font-bold text-emerald-800 mb-4">Informasi Supplier</h2>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Nama Supplier -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Supplier <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="supplier_name" 
                                           value="{{ old('supplier_name', $order->supplier_name) }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" 
                                              rows="2"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">{{ old('notes', $order->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Item Order -->
                        <div>
                            <h2 class="text-lg font-bold text-emerald-800 mb-4">Daftar Item Order</h2>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden border border-gray-200">
                                    <thead class="bg-emerald-50">
                                        <tr>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Satuan</th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Jumlah <span class="text-red-500">*</span></th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Harga/Unit <span class="text-red-500">*</span></th>
                                            <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Subtotal (Est.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach ($order->items as $index => $item)
                                        <tr class="hover:bg-emerald-50/50 transition-colors">
                                            <td class="px-6 py-5 font-medium text-gray-900">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                    {{ $item->product->name }}
                                                </div>
                                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                            </td>
                                            <td class="px-6 py-5 text-sm text-gray-600">
                                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium">
                                                    {{ $item->product->unit }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5">
                                                @php
                                                    $isDecimal = in_array(strtolower($item->product->unit), ['kg', 'liter', 'l']);
                                                @endphp
                                                <input type="number"
                                                       name="items[{{ $index }}][quantity]"
                                                       value="{{ old("items.$index.quantity", $item->quantity) }}"
                                                       min="{{ $isDecimal ? 0.001 : 1 }}"
                                                       step="{{ $isDecimal ? 0.001 : 1 }}"
                                                       required
                                                       class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex items-center">
                                                    <span class="mr-2 text-gray-600 font-medium">Rp</span>
                                                    <input type="number"
                                                           name="items[{{ $index }}][cost_per_unit]"
                                                           value="{{ old("items.$index.cost_per_unit", $item->cost_per_unit) }}"
                                                           min="0"
                                                           step="0.01"
                                                           required
                                                           class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-sm font-medium text-gray-600">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                <p class="text-xs text-gray-400 mt-1">(Hitung ulang setelah simpan)</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-emerald-50">
                                        <tr>
                                            <td colspan="4" class="px-6 py-5 text-right text-lg font-bold text-gray-900">
                                                Total Biaya Saat Ini:
                                            </td>
                                            <td class="px-6 py-5 text-lg font-bold text-emerald-700">
                                                Rp {{ number_format($order->total_cost, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <div class="mt-3 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-r flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold mb-1">Catatan Penting:</p>
                                    <ul class="text-sm space-y-1 list-disc list-inside">
                                        <li>Total biaya akan dihitung ulang otomatis setelah Anda menyimpan perubahan</li>
                                        <li>Perubahan pada order ini tidak akan mempengaruhi stok produk</li>
                                        <li>Stok akan ditambahkan setelah Anda konfirmasi order sudah diterima</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Order Info Summary -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Order</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Tanggal Order:</span>
                                    <span class="ml-2 font-medium text-gray-900">{{ $order->created_at->format('d F Y, H:i') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        Pending
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Jumlah Item:</span>
                                    <span class="ml-2 font-medium text-gray-900">{{ $order->items->count() }} item</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Total Biaya Saat Ini:</span>
                                    <span class="ml-2 font-medium text-emerald-700">Rp {{ number_format($order->total_cost, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('orders.index') }}"
                               class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 text-lg font-medium rounded-xl shadow-md transition-all duration-300 text-center">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection