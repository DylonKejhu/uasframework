<h1>Edit Kategori</h1>

<a href="{{ route('categories.index') }}"><button>Kembali</button></a>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>Nama Kategori:</label><br>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
    </div>
    <div style="margin-top:10px;">
        <button type="submit">Update</button>
    </div>
</form>
