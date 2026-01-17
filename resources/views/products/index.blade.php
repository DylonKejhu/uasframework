<h1>Daftar Produk - ParamaFresh</h1>

<!-- Tambah Produk -->
<a href="{{ route('products.create') }}">
    <button>+ Tambah Produk</button>
</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
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
        @foreach($products as $i => $product)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->unit }}</td>
            <td>{{ $product->stock_quantity }}</td>
            <td>
                <!-- Edit Produk-->
                <a href="{{ route('products.edit', $product->id) }}">
                    <button>Edit</button>
                </a>

                <!-- Hapus Produk-->
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
