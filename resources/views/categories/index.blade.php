@extends('layouts.app')

@section('title', 'Daftar Kategori - ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-50">
        <div class="flex">
            <!-- Sidebar Navigation -->
            <aside class="hidden md:block w-64 bg-emerald-800 text-white h-screen sticky top-0 overflow-y-auto shadow-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold tracking-tight mb-10">ParamFresh</h1>
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <a href="{{ route('products.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Produk
                        </a>

                        <a href="{{ route('categories.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ Route::currentRouteName() == 'categories.index' ? 'bg-emerald-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Kategori
                        </a>

                        <a href="{{ route('transactions.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Transaksi
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-10">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Kategori</h1>
                        <p class="text-emerald-700 mt-2">Kelola grup produk seperti Sayuran, Bumbu, dll</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <!-- Tambah Kategori -->
                        <a href="{{ route('categories.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kategori Baru
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-emerald-200/50">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-5 text-left text-sm font-semibold text-emerald-800 uppercase tracking-wider">Nama Kategori</th>
                                    <th class="px-6 py-5 text-center text-sm font-semibold text-emerald-800 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($categories as $i => $category)
                                <tr class="hover:bg-emerald-50/50 transition-colors duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
                                    <td class="px-6 py-5 font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="px-6 py-5 text-center text-sm">
                                        <div class="flex items-center justify-center gap-5">
                                            <!-- Edit -->
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                               class="inline-flex items-center px-5 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium rounded-lg transition border border-indigo-200 hover:border-indigo-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin hapus kategori ini? Ini akan mempengaruhi produk terkait!')"
                                                        class="inline-flex items-center px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition border border-red-200 hover:border-red-300">
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
                                        <td colspan="3" class="px-6 py-20 text-center text-gray-600 italic">
                                            Belum ada kategori terdaftar.<br>
                                            Klik tombol di atas untuk menambahkan kategori pertama Anda!
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