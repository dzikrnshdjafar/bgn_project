@section('title', 'Tambah Jadwal Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tambah Jadwal Menu - {{ $dapurSehat->nama_dapur }}</h4>
                    <a href="{{ route('jadwal-menu.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informasi:</strong> Jadwal menu ini akan berlaku untuk <strong>semua sekolah</strong> yang terdaftar di {{ $dapurSehat->nama_dapur }}
                    </div>

                    <form action="{{ route('jadwal-menu.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                                    <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror" required>
                                        <option value="">-- Pilih Hari --</option>
                                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                        <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                        <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                    </select>
                                    @error('hari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Menu Makanan <span class="text-danger">*</span></label>
                                <p class="text-muted small">Pilih 1 makanan dari setiap kategori untuk menu lengkap</p>
                                
                                @foreach($kategoriMakanans as $kategori)
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
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
                                                                {{ old('makanan_kategori.'.$kategori->id) == $makanan->id ? 'checked' : '' }}
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
                                <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
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
