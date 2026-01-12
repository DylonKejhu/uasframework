<h1>Parama Fresh</h1>

<h3>Kategori</h3>
<ul>
    @foreach ($categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

<hr>

<h3>Daftar Produk</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Satuan</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->stock_quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
