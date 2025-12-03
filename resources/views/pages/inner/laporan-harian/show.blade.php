@section('title', 'Detail Laporan Harian')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Detail Laporan Harian Kehadiran</h4>
                        <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Sekolah</th>
                                    <td>: {{ $laporan->sekolah->nama_sekolah ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laporan</th>
                                    <td>: {{ \Carbon\Carbon::parse($laporan->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Siswa Terdaftar</th>
                                    <td>: <strong>{{ $laporan->total_siswa }} siswa</strong></td>
                                </tr>
                                <tr>
                                    <th>Menu Makanan</th>
                                    <td>: 
                                        @if($laporan->makanan)
                                            <span class="badge bg-info">
                                                <i class="bi bi-egg-fried me-1"></i>{{ $laporan->makanan->nama_makanan }}
                                            </span>
                                        @else
                                            <span class="text-muted">Belum dipilih</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light-primary">
                                <div class="card-body text-center">
                                    <h5 class="text-primary">Persentase Kehadiran</h5>
                                    @php
                                        $persentase = $laporan->total_siswa > 0 
                                            ? round(($laporan->siswa_hadir / $laporan->total_siswa) * 100, 1) 
                                            : 0;
                                    @endphp
                                    <h1 class="text-primary mb-0">{{ $persentase }}%</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light-success mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="text-success mb-1">Siswa Hadir</h6>
                                            <h3 class="text-success mb-0">{{ $laporan->siswa_hadir }}</h3>
                                            <small class="text-muted">siswa hadir pada hari ini</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light-danger mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="text-danger mb-1">Siswa Tidak Hadir</h6>
                                            <h3 class="text-danger mb-0">{{ $laporan->siswa_tidak_hadir }}</h3>
                                            <small class="text-muted">siswa tidak hadir pada hari ini</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card {{ $laporan->status_pengantaran === 'Telah Diantarkan' ? 'bg-light-success' : 'bg-light-warning' }} mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="{{ $laporan->status_pengantaran === 'Telah Diantarkan' ? 'text-success' : 'text-warning' }} mb-2">
                                                <i class="bi {{ $laporan->status_pengantaran === 'Telah Diantarkan' ? 'bi-check-circle' : 'bi-clock' }} me-1"></i> 
                                                Status Pengantaran Makanan
                                            </h6>
                                            <h4 class="{{ $laporan->status_pengantaran === 'Telah Diantarkan' ? 'text-success' : 'text-warning' }} mb-0">
                                                {{ $laporan->status_pengantaran }}
                                            </h4>
                                        </div>
                                        @role('Operator SPPG')
                                        <div>
                                            @if($laporan->status_pengantaran === 'Belum Diantarkan')
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAntarkanShow">
                                                    <i class="bi bi-truck me-1"></i> Antarkan Makanan
                                                </button>
                                            @else
                                                <form action="{{ route('laporan-harian.updateStatus', $laporan->id) }}" method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan status pengantaran?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Batalkan Pengantaran
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        @endrole
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($laporan->keterangan)
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light-info">
                                <div class="card-body">
                                    <h6 class="text-info mb-2">
                                        <i class="bi bi-info-circle me-1"></i> Keterangan
                                    </h6>
                                    <p class="mb-0">{{ $laporan->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                Dibuat pada: {{ $laporan->created_at->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @role('Operator SPPG')
    @if($laporan->status_pengantaran === 'Belum Diantarkan')
    <!-- Modal Pilih Menu Makanan -->
    <div class="modal fade" id="modalAntarkanShow" tabindex="-1" aria-labelledby="modalAntarkanShowLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('laporan-harian.updateStatus', $laporan->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAntarkanShowLabel">
                            <i class="bi bi-truck me-2"></i>Konfirmasi Pengantaran Makanan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <p><strong>Sekolah:</strong> {{ $laporan->sekolah->nama_sekolah }}</p>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</p>
                            <p><strong>Siswa Hadir:</strong> {{ $laporan->siswa_hadir }} siswa</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="makanan_id_show" class="form-label">
                                <i class="bi bi-egg-fried me-1"></i>Pilih Menu Makanan yang Diantarkan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="makanan_id_show" name="makanan_id" required>
                                <option value="">-- Pilih Menu Makanan --</option>
                                @foreach($makanans as $makanan)
                                    <option value="{{ $makanan->id }}">{{ $makanan->nama_makanan }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Menu makanan yang telah diinput oleh Operator BGN</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Konfirmasi Antarkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endrole
</x-app-layout>
