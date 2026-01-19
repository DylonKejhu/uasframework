<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ParamFresh</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'emerald-primary': '#10b981',
                        'emerald-dark': '#065f46',
                        'emerald-light': '#d1fae5',
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-gradient-to-br from-emerald-50 to-green-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
                <!-- Header with Logo -->
                <div class="bg-emerald-600 px-8 py-10 text-center">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('logo.webp') }}" alt="ParamFresh" class="h-50 w-auto">
                    </div>
                    <p class="text-emerald-50 text-sm font-light">Aneka Sembako, Sayur Mayur, Lauk Pauk, Bumbu<br>Dan Perlengkapan Dapur Lainnya</p>
                </div>

                <!-- Form -->
                <div class="p-8 lg:p-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   placeholder="kejumanis@example.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required
                                   placeholder="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" 
                                       name="remember" 
                                       class="w-5 h-5 text-emerald-600 bg-white border-2 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500 focus:ring-offset-0 transition-all cursor-pointer checked:bg-emerald-600 checked:border-emerald-600">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 transition-colors select-none">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>