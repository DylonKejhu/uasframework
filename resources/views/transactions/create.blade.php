<h1>Transaksi Baru</h1>

<a href="{{ route('transactions.index') }}">
    <button type="button">Kembali</button>
</a>

{{-- Tampilkan error --}}
@if ($errors->any())
    <div style="background: #fee; border: 1px solid #c00; padding: 10px; margin: 10px 0; border-radius: 4px;">
        <strong style="color: #c00;">Error:</strong>
        <ul style="margin: 5px 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li style="color: #c00;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('transactions.store') }}" method="POST">
    @csrf

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 15px;">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
            <tr>
                <td style="text-align: center;">
                    <input type="checkbox" 
                           name="items[{{ $index }}][selected]" 
                           value="1"
                           {{ old("items.$index.selected") ? 'checked' : '' }}>
                    <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $product->id }}">
                </td>
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <input type="number"
                           name="items[{{ $index }}][quantity]"
                           value="{{ old("items.$index.quantity", 1) }}"
                           min="1"
                           max="{{ $product->stock_quantity }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        <button type="submit">Checkout</button>
    </div>
</form>