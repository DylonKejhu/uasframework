@extends('layouts.app')

@section('title', 'Daftar Kategori - ParamFresh')

@section('content')
    <div class="min-h-screen bg-emerald-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-emerald-900">Daftar Kategori</h1>
                    <p class="text-emerald-700 mt-2">Kelola grup produk seperti Sayuran, Bumbu, dll</p>
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

            <!-- Table Card -->
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
        </div>
    </div>
@endsection