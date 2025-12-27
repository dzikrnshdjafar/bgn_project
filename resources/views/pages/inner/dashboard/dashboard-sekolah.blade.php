@section('title', 'Dashboard Operator Sekolah')

<x-app-layout>
    <div class="page-heading">
        <h3>Dashboard Statistik</h3>
    </div>
    <div class="page-content">
        <section class="row">
            {{-- Statistik Cards untuk Operator Sekolah --}}
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswa</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($sekolah->jumlah_siswa ?? 0, 0, ',', '.') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Distribusi Bulan Ini</h6>
                                        <h6 class="font-extrabold mb-0">{{ $distribusiDiterima }}/{{ $distribusiBulanIni }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon {{ $distribusiHariIni && $distribusiHariIni->status_pengantaran == 'sudah_diterima' ? 'green' : 'red' }} mb-2">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Status Hari Ini</h6>
                                        @if($distribusiHariIni)
                                            @if($distribusiHariIni->status_pengantaran == 'sudah_diterima')
                                                <h6 class="font-extrabold mb-0 text-success">Diterima</h6>
                                            @else
                                                <h6 class="font-extrabold mb-0 text-warning">Belum</h6>
                                            @endif
                                        @else
                                            <h6 class="font-extrabold mb-0 text-muted">-</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Sekolah --}}
                @if($sekolah)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Informasi Sekolah</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th width="30%">Nama Sekolah</th>
                                            <td>{{ $sekolah->nama_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $sekolah->alamat_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>SPPG</th>
                                            <td>{{ $sekolah->sppg->nama_dapur ?? 'Belum terdaftar' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Siswa</th>
                                            <td><span class="badge bg-primary">{{ number_format($sekolah->jumlah_siswa, 0, ',', '.') }} siswa</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info --}}
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-primary">
                                <i class="bi bi-person-circle text-white" style="font-size: 2rem;"></i>
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                <h6 class="text-muted mb-0">Operator Sekolah</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Quick Links</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('jadwal-menus.sekolah') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-calendar-check me-2"></i> Jadwal Menu
                            </a>
                            <a href="{{ route('distribusi.today') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-truck me-2"></i> Distribusi Hari Ini
                            </a>
                            <a href="{{ route('distribusi.index') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-clock-history me-2"></i> Riwayat Distribusi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
