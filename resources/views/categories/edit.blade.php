@extends('layouts.app')

@section('title', 'Edit Kategori: ' . $category->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Edit Kategori</h1>
                            <p class="mt-2 text-emerald-100 text-lg font-medium">{{ $category->name }}</p>
                        </div>

                        <a href="{{ route('categories.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8 lg:p-12">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kategori -->
                        <div class="space-y-2">
                            <label for="name" class="block text-lg font-medium text-gray-800">Nama Kategori</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $category->name) }}" required
                                   class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-lg shadow-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-10 flex justify-end">
                            <button type="submit"
                                    class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection