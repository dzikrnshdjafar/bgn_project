@section('title', 'Edit Data Sekolah')

<x-app-layout>
    <x-form-card :title="'Edit Data Sekolah'" :backLink="route('dashboard')">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <form action="{{ route('sekolah.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="form-control" id="nama_sekolah" 
                       value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="alamat_sekolah">Alamat Sekolah</label>
                <textarea name="alamat_sekolah" class="form-control" id="alamat_sekolah" rows="3" required>{{ old('alamat_sekolah', $sekolah->alamat_sekolah ?? '') }}</textarea>
            </div>

            @if($sekolah->exists && $sekolah->sppg)
                <div class="alert alert-info mt-3">
                    <h6 class="alert-heading"><i class="bi bi-building"></i> Informasi SPPG</h6>
                    <p class="mb-1"><strong>Dapur:</strong> {{ $sekolah->sppg->nama_dapur }}</p>
                    <hr>
                    <p class="mb-0 small">Sekolah ini dilayani oleh {{ $sekolah->sppg->nama_dapur }}.</p>
                </div>
            @elseif($sekolah->exists)
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i> Sekolah ini belum terdaftar di SPPG manapun.
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </x-form-card>
</x-app-layout>
