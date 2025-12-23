@section('title', 'Tambah Sekolah ke SPPG')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tambah Sekolah ke {{ $dapurSehat->nama_dapur }}</h4>
                    <a href="{{ route('sppg-sekolah.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($availableSekolahs->isEmpty())
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Tidak ada sekolah yang tersedia. Semua sekolah sudah terdaftar pada SPPG.
                        </div>
                        <a href="{{ route('sppg-sekolah.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    @else
                        <form action="{{ route('sppg-sekolah.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="sekolah_id" class="form-label">Pilih Sekolah <span class="text-danger">*</span></label>
                                <select name="sekolah_id" id="sekolah_id" class="form-select @error('sekolah_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Sekolah --</option>
                                    @foreach($availableSekolahs as $sekolah)
                                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                                            {{ $sekolah->nama_sekolah }} - {{ $sekolah->alamat_sekolah }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sekolah_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Tambah Sekolah
                                </button>
                                <a href="{{ route('sppg-sekolah.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-lg me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
