@extends('layouts.app')

@section('title', 'Tambah User Baru|ParamFresh')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header -->
                <div class="bg-emerald-600 px-8 py-10 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Tambah User Baru</h1>
                            <p class="mt-2 text-emerald-100 text-lg">Buat akun pengguna baru untuk sistem</p>
                        </div>

                        <a href="{{ route('users.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg backdrop-blur-sm transition-all border border-white/30 hover:border-white/50">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8 lg:p-12">
                    @if ($errors->any())
                        <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label for="name" class="block text-lg font-medium text-gray-800">Nama Lengkap</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="Contoh: John Doe"
                                   class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-lg shadow-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-lg font-medium text-gray-800">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="user@example.com"
                                   class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-lg shadow-sm">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password & Confirmation -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="password" class="block text-lg font-medium text-gray-800">Password</label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       required
                                       placeholder="Minimal 8 karakter"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-lg shadow-sm transition-all">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-lg font-medium text-gray-800">Konfirmasi Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       required
                                       placeholder="Ulangi password"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-lg shadow-sm transition-all">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="space-y-2">
                            <label for="role" class="block text-lg font-medium text-gray-800">Role</label>
                            <select name="role" 
                                    id="role" 
                                    required
                                    class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white text-lg shadow-sm transition-all">
                                <option value="">-- Pilih Role --</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                @if(auth()->user()->isOwner())
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                @endif
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8 flex justify-end">
                            <button type="submit"
                                    class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection