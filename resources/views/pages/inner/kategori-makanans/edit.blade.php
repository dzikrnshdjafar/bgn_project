@section('title', 'Edit Kategori Makanan')

<x-app-layout>
    <x-form-card :title="'Form Edit Kategori Makanan'" :backLink="route('kategori-makanans.index')">
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

        <form action="{{ route('kategori-makanans.update', $kategoriMakanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="{{ old('nama_kategori', $kategoriMakanan->nama_kategori) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi', $kategoriMakanan->deskripsi) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-save me-1"></i> Update Kategori
            </button>
        </form>
    </x-form-card>
</x-app-layout>
