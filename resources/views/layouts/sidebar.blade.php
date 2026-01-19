<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="hidden md:block w-64 bg-emerald-800 text-white h-screen sticky top-0 overflow-y-auto shadow-lg">
    <div class="p-6">
        <h1 class="text-2xl font-bold tracking-tight mb-10">ParamFresh</h1>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ Route::currentRouteName() == 'dashboard' ? 'bg-emerald-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            @auth
                @if(auth()->user()->canAccessOwnerFeatures())
                    <a href="{{ route('products.index') }}"
                       class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ Route::currentRouteName() == 'products.index' ? 'bg-emerald-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Produk
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ Route::currentRouteName() == 'categories.index' ? 'bg-emerald-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori
                    </a>
                @endif

                <a href="{{ route('transactions.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ str_starts_with(Route::currentRouteName(), 'transactions.') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Transaksi
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ str_starts_with(Route::currentRouteName(), 'orders.') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Orderan
                </a>

                @if(auth()->user()->canManageUsers())
                    <a href="{{ route('users.index') }}"
                       class="flex items-center px-4 py-3 rounded-lg hover:bg-emerald-700 transition {{ str_starts_with(Route::currentRouteName(), 'users.') ? 'bg-emerald-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola User
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-4" onsubmit="return confirm('Yakin ingin logout?')">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg hover:bg-red-600 transition text-left">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            @endauth
        </nav>
    </div>
</aside>