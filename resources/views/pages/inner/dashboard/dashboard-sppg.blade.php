@section('title', 'Dashboard Operator SPPG')

<x-app-layout>
    <div class="page-heading">
        <h3>Dashboard Statistik</h3>
    </div>
    <div class="page-content">
        <section class="row">
            {{-- Statistik Cards untuk Operator SPPG --}}
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Sekolah</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalSekolah }}</h6>
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
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Siswa</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($totalSiswa, 0, ',', '.') }}</h6>
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
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Distribusi Hari Ini</h6>
                                        <h6 class="font-extrabold mb-0">{{ $distribusiDiterima }}/{{ $distribusiHariIni }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sekolah dengan Siswa Terbanyak --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sekolah dengan Siswa Terbanyak</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Sekolah</th>
                                                <th>Jumlah Siswa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($sekolahTerbanyak as $index => $sekolah)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $sekolah->nama_sekolah }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ number_format($sekolah->jumlah_siswa, 0, ',', '.') }} siswa</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Belum ada sekolah terdaftar</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <h6 class="text-muted mb-0">Operator SPPG</h6>
                            </div>
                        </div>
                    </div>
                </div>

                @if($sppg)
                    <div class="card">
                        <div class="card-header">
                            <h4>Info SPPG</h4>
                        </div>
                        <div class="card-body">
                            <h5>{{ $sppg->nama_dapur }}</h5>
                            <p class="text-muted">{{ $sppg->alamat_dapur }}</p>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Quick Links</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('sppg.sekolahs') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-building me-2"></i> Kelola Sekolah
                            </a>
                            <a href="{{ route('jadwal-menus.index') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-calendar-check me-2"></i> Jadwal Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
