<h1>Tambah Kategori Baru</h1>

<a href="{{ route('categories.index') }}"><button>Kembali</button></a>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div>
        <label>Nama Kategori:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div style="margin-top:10px;">
        <button type="submit">Simpan</button>
    </div>
</form>
