<h1>Edit Produk</h1>

<a href="{{ route('products.index') }}"><button>Kembali</button></a>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nama Produk:</label><br>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
    </div>

    <div>
        <label>Kategori:</label><br>
        <select name="category_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Harga:</label><br>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
    </div>

    <div>
        <label>Satuan:</label><br>
        <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required>
    </div>

    <div>
        <label>Stok:</label><br>
        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
    </div>

    <div style="margin-top:10px;">
        <button type="submit">Update</button>
    </div>
</form>
