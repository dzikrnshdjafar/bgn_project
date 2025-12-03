@section('title', 'Ubah Makanan')

<x-app-layout>
    <x-form-card :title="'Form Ubah Makanan'" :backLink="route('makanans.index')">
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

        <form action="{{ route('makanans.update', $makanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_makanan">Nama Makanan</label>
                <input type="text" name="nama_makanan" class="form-control" id="nama_makanan" value="{{ old('nama_makanan', $makanan->nama_makanan) }}" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi', $makanan->deskripsi) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Ubah Makanan</button>
        </form>
    </x-form-card>
</x-app-layout>
