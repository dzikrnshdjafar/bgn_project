@section('title', 'Tambah Menu')

<x-app-layout>
    <x-form-card :title="'Form Tambah Menu'" :backLink="route('menus.index')">
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

        <form action="{{ route('menus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kategori_menu_id">Kategori Menu <span class="text-danger">*</span></label>
                <select name="kategori_menu_id" id="kategori_menu_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriMenus as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_menu_id', request('kategori_menu_id')) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_menu">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="nama_menu" class="form-control" id="nama_menu" value="{{ old('nama_menu') }}" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </x-form-card>
</x-app-layout>
