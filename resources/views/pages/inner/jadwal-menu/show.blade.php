@section('title', 'Detail Jadwal Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Jadwal Menu</h4>
                    <a href="{{ route('jadwal-menu.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $jadwalMenu->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">SPPG:</div>
                        <div class="col-md-9">{{ $jadwalMenu->dapurSehat->nama_dapur }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Berlaku untuk:</div>
                        <div class="col-md-9">
                            <span class="badge bg-success">{{ $jadwalMenu->dapurSehat->sekolahs->count() }} Sekolah Terdaftar</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Hari:</div>
                        <div class="col-md-9">
                            <span class="badge bg-info">{{ $jadwalMenu->hari }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Tanggal:</div>
                        <div class="col-md-9">{{ $jadwalMenu->tanggal->format('d M Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Menu Makanan:</div>
                        <div class="col-md-9">
                            @php
                                $makananByKategori = $jadwalMenu->makanans->groupBy('kategoriMakanan.nama_kategori');
                            @endphp
                            
                            @foreach($makananByKategori as $kategori => $makanans)
                                <div class="mb-3">
                                    <h6 class="text-primary mb-2">{{ $kategori ?? 'Tanpa Kategori' }}</h6>
                                    <ul class="mb-0">
                                        @foreach($makanans as $makanan)
                                            <li>{{ $makanan->nama_makanan }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($jadwalMenu->keterangan)
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Keterangan:</div>
                            <div class="col-md-9">{{ $jadwalMenu->keterangan }}</div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Dibuat:</div>
                        <div class="col-md-9">{{ $jadwalMenu->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Diperbarui:</div>
                        <div class="col-md-9">{{ $jadwalMenu->updated_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('jadwal-menu.edit', $jadwalMenu->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('jadwal-menu.destroy', $jadwalMenu->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal menu ini?')">
                                <i class="bi bi-trash3 me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
