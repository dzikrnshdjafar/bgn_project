@section('title', 'Distribusi Hari Ini')

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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Distribusi Menu Hari Ini</h4>
                        <p class="text-muted mb-0">{{ $today->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <a href="{{ route('distribusi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($distribusiToday)
                        <!-- Info Sekolah & SPPG -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-building fs-3 text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-1 text-muted">Sekolah</h6>
                                        <p class="mb-0 fw-bold">{{ $sekolah->nama_sekolah }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-shop fs-3 text-success me-3"></i>
                                    <div>
                                        <h6 class="mb-1 text-muted">SPPG</h6>
                                        <p class="mb-0 fw-bold">{{ $distribusiToday->sppg->nama_dapur }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Status Pengantaran -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-truck fs-3 text-info me-3"></i>
                                    <div>
                                        <h6 class="mb-1 text-muted">Status Pengantaran</h6>
                                        @if($distribusiToday->status_pengantaran === 'sudah_diterima')
                                            <h5 class="mb-0">
                                                <span class="badge bg-success fs-6">
                                                    <i class="bi bi-check-circle me-1"></i> Sudah Diterima
                                                </span>
                                            </h5>
                                            @if($distribusiToday->tanggal_konfirmasi)
                                                <small class="text-muted">Dikonfirmasi: {{ $distribusiToday->tanggal_konfirmasi->format('d/m/Y H:i') }}</small>
                                            @endif
                                        @else
                                            <h5 class="mb-0">
                                                <span class="badge bg-warning fs-6">
                                                    <i class="bi bi-clock me-1"></i> Belum Diterima
                                                </span>
                                            </h5>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div>
                                    @if($distribusiToday->status_pengantaran === 'belum_diterima')
                                        <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                                            <i class="bi bi-check-circle me-2"></i> Konfirmasi Penerimaan
                                        </button>
                                    @else
                                        <form action="{{ route('distribusi.batal-konfirmasi', $distribusiToday) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-lg" onclick="return confirm('Yakin ingin membatalkan konfirmasi?')">
                                                <i class="bi bi-x-circle me-2"></i> Batal Konfirmasi
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($distribusiToday->keterangan)
                            <div class="alert alert-light-info">
                                <strong><i class="bi bi-info-circle me-2"></i>Keterangan:</strong>
                                <p class="mb-0 mt-2">{{ $distribusiToday->keterangan }}</p>
                            </div>
                        @endif

                        <hr>

                        <!-- Menu Hari Ini -->
                        <div class="mb-3">
                            <h5 class="mb-3">
                                <i class="bi bi-calendar-check me-2 text-primary"></i>Menu Hari Ini 
                                <span class="badge bg-primary">{{ ucfirst($distribusiToday->jadwalMenu->hari) }}</span>
                            </h5>

                            @if($distribusiToday->jadwalMenu->details->isNotEmpty())
                                <div class="row g-3">
                                    @foreach($distribusiToday->jadwalMenu->details as $detail)
                                        <div class="col-md-6">
                                            <div class="card border-start border-primary border-4 shadow-sm">
                                                <div class="card-body">
                                                    <h6 class="text-primary mb-2">
                                                        <i class="bi bi-tag-fill me-2"></i>{{ $detail->kategoriMenu->nama_kategori }}
                                                    </h6>
                                                    <h5 class="mb-2">{{ $detail->menu->nama_menu }}</h5>
                                                    @if($detail->menu->deskripsi)
                                                        <p class="text-muted mb-0">
                                                            <small>{{ $detail->menu->deskripsi }}</small>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-light-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Menu belum tersedia untuk hari ini.
                                </div>
                            @endif
                        </div>

                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="konfirmasiModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">
                                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Penerimaan Menu
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('distribusi.konfirmasi', $distribusiToday) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-light-info">
                                                <strong>Tanggal:</strong> {{ $today->isoFormat('dddd, D MMMM YYYY') }}
                                            </div>
                                            <p class="mb-3">Apakah Anda yakin menu hari ini telah diterima dengan baik?</p>
                                            <div class="form-group">
                                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                                <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Tambahkan catatan jika ada kondisi khusus, kekurangan, atau informasi lainnya..."></textarea>
                                                <small class="text-muted">Contoh: "Menu diterima dalam kondisi baik", "Jumlah kurang 5 porsi", dll.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-1"></i> Batal
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle me-1"></i> Ya, Konfirmasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- No Distribusi Today -->
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak Ada Distribusi Hari Ini</h4>
                            <p class="text-muted mb-4">
                                @if($today->dayOfWeek == 0 || $today->dayOfWeek == 6)
                                    Distribusi menu hanya dilakukan pada hari Senin - Jumat.
                                @else
                                    Belum ada jadwal distribusi untuk hari ini.<br>
                                    Silakan hubungi admin jika ada pertanyaan.
                                @endif
                            </p>
                            <a href="{{ route('distribusi.index') }}" class="btn btn-primary">
                                <i class="bi bi-list me-1"></i> Lihat Riwayat Distribusi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
