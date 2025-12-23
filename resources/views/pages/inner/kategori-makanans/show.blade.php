@section('title', 'Detail Kategori Makanan')

<x-app-layout>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Detail Kategori Makanan</h4>
                <a href="{{ route('kategori-makanans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="25%">ID</th>
                    <td>: {{ $kategoriMakanan->id }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>: {{ $kategoriMakanan->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>: {{ $kategoriMakanan->deskripsi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Makanan</th>
                    <td>: <span class="badge bg-info">{{ $kategoriMakanan->makanans->count() }} makanan</span></td>
                </tr>
            </table>

            @if($kategoriMakanan->makanans->count() > 0)
                <hr>
                <h5>Daftar Makanan dalam Kategori Ini:</h5>
                <ul class="list-group mt-3">
                    @foreach($kategoriMakanan->makanans as $makanan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-egg-fried me-2"></i>{{ $makanan->nama_makanan }}
                            </span>
                            <a href="{{ route('makanans.show', $makanan->id) }}" class="btn btn-sm btn-light-info">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
