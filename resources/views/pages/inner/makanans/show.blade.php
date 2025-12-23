@section('title', 'Detail Makanan')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Makanan</h4>
                    <a href="{{ route('makanans.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $makanan->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Nama Makanan:</div>
                        <div class="col-md-9">{{ $makanan->nama_makanan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Kategori:</div>
                        <div class="col-md-9">
                            @if($makanan->kategoriMakanan)
                                <span class="badge bg-secondary">{{ $makanan->kategoriMakanan->nama_kategori }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Deskripsi:</div>
                        <div class="col-md-9">{{ $makanan->deskripsi ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Dibuat:</div>
                        <div class="col-md-9">{{ $makanan->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Diperbarui:</div>
                        <div class="col-md-9">{{ $makanan->updated_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('makanans.edit', $makanan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('makanans.destroy', $makanan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this makanan?')">
                                <i class="bi bi-trash3 me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
