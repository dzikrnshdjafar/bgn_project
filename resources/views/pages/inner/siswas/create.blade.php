@section('title', 'Tambah Siswa')

<x-app-layout>
    <x-form-card :title="'Form Tambah Siswa'" :backLink="route('siswas.index')">
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

        <form action="{{ route('siswas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nis">NIS</label>
                <input type="text" name="nis" class="form-control" id="nis" value="{{ old('nis') }}" required>
                <small class="form-text text-muted">Nomor Induk Siswa harus unik.</small>
            </div>

            <div class="form-group">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" id="nama_siswa" value="{{ old('nama_siswa') }}" required>
            </div>

            <div class="form-group">
                <label for="sekolah_id">Sekolah</label>
                @if(auth()->user()->hasRole('Operator Sekolah') && count($sekolahs) == 1)
                    <input type="text" class="form-control" value="{{ $sekolahs->first()->nama_sekolah }}" readonly>
                    <input type="hidden" name="sekolah_id" value="{{ $sekolahs->first()->id }}">
                    <small class="form-text text-muted">Anda hanya dapat menambahkan siswa ke sekolah Anda sendiri.</small>
                @else
                    <select name="sekolah_id" class="form-control" id="sekolah_id" required>
                        <option value="">Pilih Sekolah</option>
                        @foreach ($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                                {{ $sekolah->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="form-group">
                <label for="makanan_kesukaan_id">Makanan Kesukaan</label>
                <select name="makanan_kesukaan_id" class="form-control" id="makanan_kesukaan_id">
                    <option value="">Pilih Makanan (Opsional)</option>
                    @foreach ($makanans as $makanan)
                        <option value="{{ $makanan->id }}" {{ old('makanan_kesukaan_id') == $makanan->id ? 'selected' : '' }}>
                            {{ $makanan->nama_makanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Tambah Siswa</button>
        </form>
    </x-form-card>
</x-app-layout>

