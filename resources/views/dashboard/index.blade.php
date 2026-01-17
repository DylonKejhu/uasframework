<!-- TEMPLATE
Adjust berapa banyak produk yg bsa di display di DashboardController tepatnya pada
$products = $productsQuery->simplePaginate(AdjustDisiniInteger); -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ParamFresh</title>
</head>
<body>
    <h1>Dashboard ParamFresh</h1>
    
    <!-- Navigation -->
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a> | 
        <a href="{{ route('products.index') }}">Produk</a> | 
        <a href="{{ route('categories.index') }}">Kategori</a> | 
        <a href="{{ route('transactions.index') }}">Transaksi</a>
    </nav>
    
    <hr>
    
    <!-- Container dengan 2 kolom -->
    <div style="display: flex; gap: 20px;">
        
        <!-- Kolom Kiri: Kategori -->
        <div style="width: 250px;">
            <h2>Kategori</h2>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 10px;">
                    <a href="{{ route('dashboard') }}" style="text-decoration: none; color: {{ !request('category_id') ? 'blue' : 'black' }}; font-weight: {{ !request('category_id') ? 'bold' : 'normal' }};">
                        Semua Kategori
                    </a>
                </li>
                @foreach($categories as $category)
                    <li style="margin-bottom: 10px;">
                        <a href="{{ route('dashboard', ['category_id' => $category->id]) }}" 
                           style="text-decoration: none; color: {{ request('category_id') == $category->id ? 'blue' : 'black' }}; font-weight: {{ request('category_id') == $category->id ? 'bold' : 'normal' }};">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Kolom Kanan: Daftar Produk -->
        <div style="flex: 1;">
            <h2>Daftar Produk</h2>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('dashboard') }}" style="margin-bottom: 20px;">
                <!-- @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif -->
                
                <label for="search">Cari Produk:</label>
                <input type="text" 
                       id="search"
                       name="search" 
                       placeholder="Masukkan nama produk..." 
                       value="{{ request('search') }}">
                
                <button type="submit">Cari</button>
                <a href="{{ route('dashboard', request()->only('category_id')) }}">
                    <button type="button">Reset Pencarian</button>
                </a>
            </form>
            
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}">
                                <button type="button">Edit</button>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">
                            @if(request('search'))
                                Tidak ada produk yang sesuai dengan pencarian
                            @elseif(request('category_id'))
                                Tidak ada produk dalam kategori ini
                            @else
                                Belum ada produk
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $products->links() }}
            </div>
            
            <a href="{{ route('products.create') }}">
                <button type="button" style="margin-top: 15px;">Tambah Produk Baru</button>
            </a>
        </div>
        
    </div>
    
    <hr>
    
    <!-- Statistics -->
    <h2>Statistik</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Total Produk</th>
            <th>Total Kategori</th>
            <th>Total Transaksi</th>
            <th>Total Pendapatan</th>
        </tr>
        <tr>
            <td>{{ $totalProducts }}</td>
            <td>{{ $totalCategories }}</td>
            <td>{{ $totalTransactions }}</td>
            <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <hr>
    
    <!-- Low Stock Alert -->
    <h2>Stok Menipis (Stok < 10)</h2>
    @if($lowStockProducts->count() > 0)
        <p><strong>PERINGATAN: {{ $lowStockProducts->count() }} produk stok menipis!</strong></p>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>{{ $product->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Semua produk stok aman</p>
    @endif
    
    <hr>
    
    <!-- Best Selling Products -->
    <h2>Produk Terlaris</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bestSellingProducts as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_sold }} pcs</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data penjualan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <hr>
    
    <!-- Recent Transactions -->
    <h2>Transaksi Terbaru</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('transactions.index') }}"><button type="button">Lihat Semua Transaksi</button></a>
    
    <hr>
    
    <!-- Riwayat Transaksi (7 Hari Terakhir) -->
    <h2>Riwayat Transaksi (7 Hari Terakhir)</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactionChart as $chart)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($chart->date)) }}</td>
                    <td>{{ $chart->total }}</td>
                    <td>Rp {{ number_format($chart->revenue, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data transaksi 7 hari terakhir</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>