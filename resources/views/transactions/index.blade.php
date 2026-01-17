<h1>Daftar Transaksi</h1>

<a href="{{ route('transactions.create') }}">
    <button type="button">Transaksi Baru</button>
</a>

{{-- Success message --}}
@if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 15px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Total Harga</th>
            <th>Items</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            <td>
                <ul>
                    @foreach ($transaction->items as $item)
                        <li>{{ $item->product->name }} x {{ $item->quantity }} = Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align: center;">Belum ada transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>