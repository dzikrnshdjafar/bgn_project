@section('title', 'Edit Data Dapur')

<x-app-layout>
    <x-form-card :title="'Edit Data Dapur'" :backLink="route('dashboard')">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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

        <form action="{{ route('sppg.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_dapur">Nama Dapur</label>
                <input type="text" name="nama_dapur" class="form-control" id="nama_dapur" 
                       value="{{ old('nama_dapur', $sppg->nama_dapur ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" rows="3" required>{{ old('alamat', $sppg->alamat ?? '') }}</textarea>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                @if($sppg->exists)
                    <a href="{{ route('sppg.sekolahs') }}" class="btn btn-success">
                        <i class="bi bi-building"></i> Kelola Sekolah Zona Pengantaran
                    </a>
                @endif
            </div>
        </form>
    </x-form-card>
</x-app-layout>
