<h1>Daftar Kategori</h1>
<!-- Membuat kategori -->
<a href="{{ route('categories.create') }}"><button>+ Tambah Kategori</button></a>

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $i => $category)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $category->name }}</td>
            <td>
                <!-- Mengedit Kategori -->
                <a href="{{ route('categories.edit', $category->id) }}"><button>Edit</button></a>
                    <!-- Menghapus Kategori -->
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
