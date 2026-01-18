@extends('layouts.app')

@section('title', 'Daftar Transaksi - ParamFresh')

@section('content')
    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-emerald-50 to-white">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Transaksi</h1>
                    <p class="text-emerald-700 mt-2">Riwayat penjualan dan pembelian di toko Anda</p>
                </div>

                <div class="flex flex-wrap gap-4">
                    <!-- Kembali ke Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 bg-emerald-800 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-all duration-200 border border-emerald-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>

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

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Transactions Table -->
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
                                                    {{ $item->product->name }} × {{ $item->quantity }}
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
                                        Belum ada transaksi.<br>
                                        Klik tombol di atas untuk membuat transaksi pertama Anda!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection