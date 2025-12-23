@section('title', 'Edit Jadwal Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Jadwal Menu - {{ $jadwalMenu->hari }}</h4>
                    <a href="{{ route('jadwal-menu.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informasi:</strong> Jadwal menu ini berlaku untuk <strong>semua sekolah</strong> yang terdaftar di {{ $dapurSehat->nama_dapur }}
                    </div>

                    <form action="{{ route('jadwal-menu.update', $jadwalMenu->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- <div class="mb-4">
                            <label class="form-label fw-bold">Hari</label>
                            <div class="p-3 bg-light rounded">
                                <span class="badge bg-info fs-6">{{ $jadwalMenu->hari }}</span>
                            </div>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Pilih Menu Makanan <span class="text-danger">*</span></label>
                            <p class="text-muted small">Pilih 1 makanan dari setiap kategori untuk menu lengkap</p>
                            
                            @php
                                // Group selected makanans by kategori_makanan_id
                                $selectedByKategori = [];
                                foreach($jadwalMenu->makanans as $makanan) {
                                    if($makanan->kategori_makanan_id) {
                                        $selectedByKategori[$makanan->kategori_makanan_id] = $makanan->id;
                                    }
                                }
                                // Merge with old input if validation failed
                                if(old('makanan_kategori')) {
                                    $selectedByKategori = old('makanan_kategori');
                                }
                                @endphp
                            
                            @foreach($kategoriMakanans as $kategori)
                            <div class="card mb-3">
                                <div class="card-header">
                                        <hr>
                                        <h6 class="mb-0">{{ $kategori->nama_kategori }} <span class="text-danger">*</span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @forelse($kategori->makanans as $makanan)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="radio" 
                                                            name="makanan_kategori[{{ $kategori->id }}]" 
                                                            value="{{ $makanan->id }}" 
                                                            id="makanan_{{ $makanan->id }}"
                                                            {{ isset($selectedByKategori[$kategori->id]) && $selectedByKategori[$kategori->id] == $makanan->id ? 'checked' : '' }}
                                                            required
                                                        >
                                                        <label class="form-check-label" for="makanan_{{ $makanan->id }}">
                                                            {{ $makanan->nama_makanan }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @empty
                                                <div class="col-12">
                                                    <p class="text-muted mb-0">Tidak ada makanan dalam kategori ini</p>
                                                </div>
                                                @endforelse
                                            </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @error('makanan_kategori')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $jadwalMenu->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Simpan
                            </button>
                            <a href="{{ route('jadwal-menu.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
