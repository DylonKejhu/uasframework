@extends('layouts.app')

@section('title', 'Daftar Order - ParamaFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-4 mb-10">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Order</h1>
                        <p class="text-emerald-700 mt-2">Kelola pembelian stok dari supplier</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <!-- Tambah Order -->
                        <a href="{{ route('orders.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Order Baru
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-emerald-100">
                    <form method="GET" action="{{ route('orders.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Date From -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" 
                                       name="date_from" 
                                       value="{{ request('date_from') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                <input type="date" 
                                       name="date_to" 
                                       value="{{ request('date_to') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('orders.index') }}"
                               class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Main Table Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-emerald-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Supplier</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Total Biaya</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Jumlah Item</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Catatan</th>
                                    <th class="px-6 py-5 text-center text-sm font-semibold text-emerald-800 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-5 text-center text-sm font-semibold text-emerald-800 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($orders as $i => $order)
                                <tr class="hover:bg-emerald-50 transition-colors duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-5 font-medium text-gray-900">{{ $order->supplier_name }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-emerald-700">
                                        Rp {{ number_format($order->total_cost, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600 text-center">
                                        {{ $order->items->count() }} item
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600">
                                        {{ $order->notes ? Str::limit($order->notes, 30) : '—' }}
                                    </td>
                                    <td class="px-6 py-5 text-center text-sm">
                                        @if($order->status === 'received')
                                            <span class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 font-semibold rounded-lg border border-emerald-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Diterima
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 font-semibold rounded-lg border border-orange-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center text-sm">
                                        <div class="flex items-center justify-center gap-3">
                                            @if($order->status === 'pending')
                                                <!-- Edit Button -->
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                   class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium rounded-lg transition border border-indigo-200 hover:border-indigo-300">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <!-- Confirm Received Button -->
                                                <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="_confirm_received" value="1">
                                                    <button type="submit"
                                                            onclick="return confirm('Konfirmasi bahwa order ini sudah diterima?\n\nStok produk akan ditambahkan dan order tidak bisa diubah lagi.')"
                                                            class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium rounded-lg transition border border-emerald-200 hover:border-emerald-300">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Konfirmasi Diterima
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 italic text-xs">Sudah dikonfirmasi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Detail Row (Expandable) -->
                                <tr class="bg-emerald-50/30">
                                    <td colspan="8" class="px-6 py-6">
                                        <div class="bg-white rounded-lg p-6 shadow-sm border border-emerald-200">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-bold text-emerald-800">Detail Order #{{ $order->id }}</h3>
                                                @if($order->status === 'received')
                                                    <span class="text-xs text-gray-500">Dikonfirmasi: {{ $order->updated_at->format('d/m/Y H:i') }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <span class="font-semibold text-gray-700">Supplier:</span>
                                                    <span class="text-gray-600 ml-2">{{ $order->supplier_name }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-700">Tanggal Order:</span>
                                                    <span class="text-gray-600 ml-2">{{ $order->created_at->format('d F Y, H:i') }}</span>
                                                </div>
                                                @if($order->notes)
                                                    <div class="md:col-span-2">
                                                        <span class="font-semibold text-gray-700">Catatan:</span>
                                                        <span class="text-gray-600 ml-2">{{ $order->notes }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Unit</th>
                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($order->items as $item)
                                                        <tr>
                                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->name }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                                @php
                                                                    $qty = rtrim(rtrim(number_format($item->quantity, 3, '.', ''), '0'), '.');
                                                                @endphp
                                                                {{ $qty }} {{ $item->product->unit }}
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                                Rp {{ number_format($item->cost_per_unit, 0, ',', '.') }}
                                                            </td>
                                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr class="bg-emerald-50 font-semibold">
                                                            <td colspan="3" class="px-4 py-3 text-right text-sm text-gray-900">Total:</td>
                                                            <td class="px-4 py-3 text-sm text-emerald-700">
                                                                Rp {{ number_format($order->total_cost, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                            @if(request('date_from') || request('date_to'))
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ditemukan order pada periode yang dipilih</p>
                                                <p class="text-sm mt-2">Coba ubah filter tanggal atau reset pencarian</p>
                                            @else
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada order terdaftar</p>
                                                <p class="text-sm mt-2">Klik tombol "Tambah Order Baru" untuk membuat order pertama Anda</p>
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