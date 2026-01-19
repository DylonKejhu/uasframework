@extends('layouts.app')

@section('title', 'Daftar Transaksi|ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-4 mb-10">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Transaksi</h1>
                        <p class="text-emerald-700 mt-2">Riwayat penjualan dan pembelian di toko Anda</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <!-- Transaksi Baru -->
                        <a href="{{ route('transactions.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Transaksi Baru
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-emerald-100">
                    <form method="GET" action="{{ route('transactions.index') }}" class="space-y-4">
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
                            <a href="{{ route('transactions.index') }}"
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
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Total Harga</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Items</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($transactions as $transaction)
                                    <tr class="hover:bg-emerald-50 transition-colors duration-200">
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700 font-medium">{{ $transaction->id }}</td>
                                        <td class="px-6 py-5 text-sm font-bold text-emerald-800">
                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($transaction->items as $item)
                                                    <li>
                                                        {{ $item->product->name }} × 
                                                        @php
                                                            $qty = rtrim(rtrim(number_format($item->quantity, 3, '.', ''), '0'), '.');
                                                        @endphp
                                                        {{ $qty }} {{ $item->product->unit }}
                                                        = Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center text-gray-500 italic bg-gray-50">
                                            @if(request('date_from') || request('date_to'))
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ditemukan transaksi pada periode yang dipilih</p>
                                                <p class="text-sm mt-2">Coba ubah filter tanggal atau reset pencarian</p>
                                            @else
                                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada transaksi terdaftar</p>
                                                <p class="text-sm mt-2">Klik tombol "Tambah Transaksi Baru" untuk membuat transaksi pertama Anda</p>
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