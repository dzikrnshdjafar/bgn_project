@section('title', 'Distribusi Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-light-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Distribusi Menu - {{ $sekolah->nama_sekolah }}</h4>
                    <p class="text-muted mb-0">SPPG: {{ $sekolah->sppg->nama_dapur ?? '-' }}</p>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <form method="GET" action="{{ route('distribusi.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="bulan" class="form-label">Bulan</label>
                                <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="belum_diterima" {{ $status === 'belum_diterima' ? 'selected' : '' }}>Belum Diterima</option>
                                    <option value="sudah_diterima" {{ $status === 'sudah_diterima' ? 'selected' : '' }}>Sudah Diterima</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>
                                <a href="{{ route('distribusi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Menu</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distribusis as $key => $distribusi)
                                    <tr>
                                        <td>{{ $distribusis->firstItem() + $key }}</td>
                                        <td>{{ $distribusi->tanggal_distribusi->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ ucfirst($distribusi->jadwalMenu->hari) }}</span>
                                        </td>
                                        <td>
                                            @if($distribusi->jadwalMenu->details->isNotEmpty())
                                                @foreach($distribusi->jadwalMenu->details as $detail)
                                                    <small class="d-block">
                                                        <strong class="text-primary">{{ $detail->kategoriMenu->nama_kategori }}:</strong>
                                                        {{ $detail->menu->nama_menu }}
                                                    </small>
                                                @endforeach
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($distribusi->status_pengantaran === 'sudah_diterima')
                                                <span class="badge bg-success">Sudah Diterima</span>
                                                @if($distribusi->tanggal_konfirmasi)
                                                    <br><small class="text-muted">{{ $distribusi->tanggal_konfirmasi->format('d/m/Y H:i') }}</small>
                                                @endif
                                            @else
                                                <span class="badge bg-warning">Belum Diterima</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($distribusi->keterangan)
                                                <small>{{ $distribusi->keterangan }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($distribusi->status_pengantaran === 'belum_diterima')
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $distribusi->id }}">
                                                    <i class="bi bi-check-circle me-1"></i> Konfirmasi
                                                </button>

                                                <!-- Modal Konfirmasi -->
                                                <div class="modal fade" id="konfirmasiModal{{ $distribusi->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Konfirmasi Penerimaan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('distribusi.konfirmasi', $distribusi) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Konfirmasi penerimaan menu untuk tanggal <strong>{{ $distribusi->tanggal_distribusi->format('d/m/Y') }}</strong>?</p>
                                                                    <div class="form-group">
                                                                        <label for="keterangan{{ $distribusi->id }}">Keterangan (Opsional)</label>
                                                                        <textarea name="keterangan" id="keterangan{{ $distribusi->id }}" class="form-control" rows="3" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <form action="{{ route('distribusi.batal-konfirmasi', $distribusi) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yakin ingin membatalkan konfirmasi?')">
                                                        <i class="bi bi-x-circle me-1"></i> Batal Konfirmasi
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data distribusi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $distribusis->appends(['bulan' => $bulan, 'status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
