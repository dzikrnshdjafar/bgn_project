@section('title', 'Tambah Makanan')

<x-app-layout>
    <x-form-card :title="'Form Tambah Makanan'" :backLink="route('makanans.index')">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('makanans.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="nama_makanan">Nama Makanan</label>
                <input type="text" name="nama_makanan" class="form-control" id="nama_makanan" value="{{ old('nama_makanan') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="kategori_makanan_id">Kategori Makanan</label>
                <select name="kategori_makanan_id" class="form-control" id="kategori_makanan_id">
                    <option value="">-- Pilih Kategori (Opsional) --</option>
                    @foreach ($kategoriMakanans as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_makanan_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Tambah Makanan</button>
        </form>
    </x-form-card>
</x-app-layout>
