@section('title', 'Detail Kategori Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Kategori Menu</h4>
                    <a href="{{ route('kategori-menus.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <h5>Informasi Kategori Menu</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Nama Kategori</label>
                                <p>{{ $kategoriMenu->nama_kategori }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Jumlah Menu</label>
                                <p>{{ $kategoriMenu->menus->count() }} menu</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="fw-bold">Keterangan</label>
                                d-flex justify-content-between align-items-center mb-3">
                        <h5>Daftar Menu</h5>
                        <a href="{{ route('menus.create', ['kategori_menu_id' => $kategoriMenu->id]) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
                        </a>
                    </div>

                    @if($kategoriMenu->menus->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kategoriMenu->menus as $key => $menu)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $menu->nama_menu }}</td>
                                            <td>{{ $menu->deskripsi ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('menus.edit', $menu) }}" class="btn btn-light-warning btn-sm">
                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada menu dalam kategori ini.</p>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('kategori-menus.edit', $kategoriMenu) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section               </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
