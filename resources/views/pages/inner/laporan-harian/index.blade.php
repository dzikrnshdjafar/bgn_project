@section('title', 'Laporan Harian Kehadiran')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-light-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-light-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <x-table-card :title="'Laporan Harian Kehadiran'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @role('Operator Sekolah')
                        <a href="{{ route('laporan-harian.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Buat Laporan Hari Ini
                        </a>
                        @endrole
                    </div>
                    
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan-harian.index') }}" class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-info me-2">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                            <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </x-slot>
                
                <x-slot name="tableHeader">
                    <tr>
                        <th>Tanggal</th>
                        @role('Operator SPPG')
                        <th>Sekolah</th>
                        @endrole
                        <th>Total Siswa</th>
                        <th>Siswa Hadir</th>
                        <th>Siswa Tidak Hadir</th>
                        <th>Persentase Kehadiran</th>
                        <th>Menu Makanan</th>
                        <th>Status Pengantaran</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                
                <x-slot name="tableBody">
                    @forelse ($laporans as $laporan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</td>
                            @role('Operator SPPG')
                            <td>{{ $laporan->sekolah->nama_sekolah ?? '-' }}</td>
                            @endrole
                            <td>{{ $laporan->total_siswa }}</td>
                            <td>
                                <span class="badge bg-success">{{ $laporan->siswa_hadir }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger">{{ $laporan->siswa_tidak_hadir }}</span>
                            </td>
                            <td>
                                @php
                                    $persentase = $laporan->total_siswa > 0 
                                        ? round(($laporan->siswa_hadir / $laporan->total_siswa) * 100, 1) 
                                        : 0;
                                    $badgeClass = $persentase >= 80 ? 'success' : ($persentase >= 60 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $persentase }}%</span>
                            </td>
                            <td>
                                @if($laporan->makanan)
                                    <span class="badge bg-info">
                                        <i class="bi bi-egg-fried me-1"></i>{{ $laporan->makanan->nama_makanan }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($laporan->status_pengantaran === 'Telah Diantarkan')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Telah Diantarkan
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock me-1"></i>Belum Diantarkan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('laporan-harian.show', $laporan->id) }}" class="btn btn-light-info me-2 mb-2">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                                @role('Operator Sekolah')
                                    @if(auth()->user()->sekolah && $laporan->sekolah_id === auth()->user()->sekolah->id)
                                    <a href="{{ route('laporan-harian.edit', $laporan->id) }}" class="btn btn-light-warning me-2 mb-2">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    @endif
                                @endrole
                                @role('Operator SPPG')
                                    @if($laporan->status_pengantaran === 'Belum Diantarkan')
                                        <button type="button" class="btn btn-light-success mb-2" data-bs-toggle="modal" data-bs-target="#modalAntarkan{{ $laporan->id }}">
                                            <i class="bi bi-truck me-1"></i> Antarkan
                                        </button>
                                    @else
                                        <form action="{{ route('laporan-harian.updateStatus', $laporan->id) }}" method="POST" style="display:inline;" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan status pengantaran?')">
                                            @csrf
                                            <button type="submit" class="btn btn-light-secondary mb-2">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Batalkan
                                            </button>
                                        </form>
                                    @endif
                                @endrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('Operator SPPG') ? '9' : '8' }}" class="text-center">
                                Tidak ada data laporan.
                            </td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table-card>
            
            <div class="mt-4">
                {{ $laporans->links() }}
            </div>
        </div>
    </section>
    
    @role('Operator SPPG')
    <!-- Modal Pilih Menu Makanan -->
    @foreach($laporans as $laporan)
        @if($laporan->status_pengantaran === 'Belum Diantarkan')
        <div class="modal fade" id="modalAntarkan{{ $laporan->id }}" tabindex="-1" aria-labelledby="modalAntarkanLabel{{ $laporan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('laporan-harian.updateStatus', $laporan->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAntarkanLabel{{ $laporan->id }}">
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
                                <label for="makanan_id{{ $laporan->id }}" class="form-label">
                                    <i class="bi bi-egg-fried me-1"></i>Pilih Menu Makanan yang Diantarkan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="makanan_id{{ $laporan->id }}" name="makanan_id" required>
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
    @endforeach
    @endrole
</x-app-layout>
