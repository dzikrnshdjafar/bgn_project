@section('title', 'Buat Laporan Harian')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-light-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <x-form-card :title="'Buat Laporan Harian Kehadiran'" :backLink="route('laporan-harian.index')">
                <form action="{{ route('laporan-harian.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-light-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>{{ $sekolah->nama_sekolah }}</strong><br>
                                Data kehadiran di bawah ini dihitung otomatis berdasarkan status kehadiran siswa hari ini.
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal" class="form-label">Tanggal Laporan</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="tanggal" 
                                       name="tanggal" 
                                       value="{{ now()->format('Y-m-d') }}" 
                                       readonly
                                       style="background-color: #e9ecef;"
                                       required>
                                <small class="text-muted">Tanggal otomatis diatur ke hari ini</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="total_siswa" class="form-label">Total Siswa Terdaftar</label>
                                <input type="number" 
                                       class="form-control @error('total_siswa') is-invalid @enderror" 
                                       id="total_siswa" 
                                       name="total_siswa" 
                                       value="{{ old('total_siswa', $totalSiswa) }}" 
                                       readonly 
                                       required>
                                @error('total_siswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="siswa_hadir" class="form-label">Jumlah Siswa Hadir</label>
                                <input type="number" 
                                       class="form-control @error('siswa_hadir') is-invalid @enderror" 
                                       id="siswa_hadir" 
                                       name="siswa_hadir" 
                                       value="{{ old('siswa_hadir', $siswaHadir) }}" 
                                       required 
                                       min="0"
                                       max="{{ $totalSiswa }}"
                                       onchange="calculateTidakHadir()">
                                @error('siswa_hadir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="siswa_tidak_hadir" class="form-label">Jumlah Siswa Tidak Hadir</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="siswa_tidak_hadir" 
                                       name="siswa_tidak_hadir" 
                                       value="{{ old('siswa_tidak_hadir', $siswaTidakHadir) }}" 
                                       readonly 
                                       style="background-color: #e9ecef;">
                                <small class="text-muted">Dihitung otomatis: Total Siswa - Siswa Hadir</small>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="4" 
                                          placeholder="Tambahkan catatan atau keterangan khusus untuk laporan hari ini...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Laporan
                        </button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </section>
    
    @push('scripts')
    <script>
        function calculateTidakHadir() {
            const totalSiswa = parseInt(document.getElementById('total_siswa').value) || 0;
            const siswaHadir = parseInt(document.getElementById('siswa_hadir').value) || 0;
            const siswaTidakHadir = totalSiswa - siswaHadir;
            document.getElementById('siswa_tidak_hadir').value = siswaTidakHadir >= 0 ? siswaTidakHadir : 0;
        }
        
        // Calculate on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateTidakHadir();
        });
    </script>
    @endpush
</x-app-layout>
