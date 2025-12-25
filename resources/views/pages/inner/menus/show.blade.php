@section('title', 'Detail Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Menu</h4>
                    <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <h5>Informasi Menu</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Nama Menu</label>
                                <p>{{ $menu->nama_menu }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Kategori Menu</label>
                                <p>
                                    <a href="{{ route('kategori-menus.show', $menu->kategoriMenu) }}" class="text-primary">
                                        {{ $menu->kategoriMenu->nama_kategori }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="fw-bold">Deskripsi</label>
                                <p>{{ $menu->deskripsi ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
