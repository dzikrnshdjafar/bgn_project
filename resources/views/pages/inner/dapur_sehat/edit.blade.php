@section('title', 'Edit Data Dapur Sehat')

<x-app-layout>
    <x-form-card :title="'Edit Data Dapur Sehat'" :backLink="route('dashboard')">
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

        <form action="{{ route('dapur_sehat.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_dapur">Nama Dapur</label>
                <input type="text" name="nama_dapur" class="form-control" id="nama_dapur" 
                       value="{{ old('nama_dapur', $dapurSehat->nama_dapur ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" rows="3" required>{{ old('alamat', $dapurSehat->alamat ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </x-form-card>
</x-app-layout>
