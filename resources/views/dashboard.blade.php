@section('title', 'Dashboard')

<x-app-layout>
    <div class="page-heading">
        <h3>
            Dashboard
            @if($namaSekolah)
                - {{ $namaSekolah }}
            @endif
        </h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <!-- Total Siswa -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Siswa</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalSiswa }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Hadir -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Siswa Hadir</h6>
                                        <h6 class="font-extrabold mb-0">{{ $siswaHadir }}</h6>
                                        @if($totalSiswa > 0)
                                            <small class="text-muted">{{ number_format(($siswaHadir / $totalSiswa) * 100, 1) }}%</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Tidak Hadir -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Siswa Tidak Hadir</h6>
                                        <h6 class="font-extrabold mb-0">{{ $siswaTidakHadir }}</h6>
                                        @if($totalSiswa > 0)
                                            <small class="text-muted">{{ number_format(($siswaTidakHadir / $totalSiswa) * 100, 1) }}%</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sekolah / Menu Makanan -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        @hasanyrole('Admin|Operator BGN|Operator SPPG')
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        @endhasanyrole
                                        @hasrole('Operator Sekolah')
                                            <div class="stats-icon orange mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        @endhasrole
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        @hasanyrole('Admin|Operator BGN|Operator SPPG')
                                            <h6 class="text-muted font-semibold">Total Sekolah</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalSekolah }}</h6>
                                        @endhasanyrole
                                        @hasrole('Operator Sekolah')
                                            <h6 class="text-muted font-semibold">Menu Makanan</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalMakanan }}</h6>
                                        @endhasrole
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Kehadiran -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ringkasan Kehadiran Siswa</h4>
                            </div>
                            <div class="card-body">
                                @if($totalSiswa > 0)
                                    <div class="progress mb-3" style="height: 40px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ ($siswaHadir / $totalSiswa) * 100 }}%"
                                             aria-valuenow="{{ $siswaHadir }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ $totalSiswa }}">
                                            <strong>Hadir: {{ $siswaHadir }} ({{ number_format(($siswaHadir / $totalSiswa) * 100, 1) }}%)</strong>
                                        </div>
                                        <div class="progress-bar bg-danger" role="progressbar" 
                                             style="width: {{ ($siswaTidakHadir / $totalSiswa) * 100 }}%"
                                             aria-valuenow="{{ $siswaTidakHadir }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ $totalSiswa }}">
                                            <strong>Tidak Hadir: {{ $siswaTidakHadir }} ({{ number_format(($siswaTidakHadir / $totalSiswa) * 100, 1) }}%)</strong>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center gap-4 mt-3">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2" style="width: 20px; height: 20px;"></span>
                                            <span>Siswa Hadir</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-danger me-2" style="width: 20px; height: 20px;"></span>
                                            <span>Siswa Tidak Hadir</span>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted text-center">Belum ada data siswa.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Aksi Cepat</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    {{-- @hasanyrole('Admin|Operator BGN|Operator Sekolah')
                                        <a href="{{ route('siswas.index') }}" class="btn btn-primary">
                                            <i class="bi bi-people me-1"></i> Kelola Data Siswa
                                        </a>
                                    @endhasanyrole --}}
                                    @hasrole('Admin')
                                    <a href="{{ route('users.index') }}" class="btn btn-info">
                                        <i class="bi bi-person-badge me-1"></i> Kelola Pengguna
                                    </a>
                                    @endhasrole
                                    
                                    @hasrole('Admin|Operator BGN')
                                        <a href="{{ route('makanans.index') }}" class="btn btn-success">
                                            <i class="bi bi-egg-fried me-1"></i> Kelola Menu Makanan
                                        </a>
                                        @endhasrole
                                    
                                    @hasrole('Operator Sekolah')
                                        <a href="{{ route('sekolah.edit') }}" class="btn btn-warning">
                                            <i class="bi bi-building me-1"></i> Edit Data Sekolah
                                        </a>
                                    @endhasrole
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Makanan dengan Like Terbanyak -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><i class="bi bi-trophy-fill text-warning"></i> Makanan dengan Like Terbanyak</h4>
                                <span class="badge bg-info">Top 10</span>
                            </div>
                            <div class="card-body">
                                @if($topLikedMakanans->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 60px;">Rank</th>
                                                    <th>Nama Makanan</th>
                                                    <th class="text-center" style="width: 120px;">Total Like</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topLikedMakanans as $index => $makanan)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if($index == 0)
                                                                <span class="badge" style="background: linear-gradient(45deg, #FFD700, #FFA500); font-size: 1rem;">
                                                                    <i class="bi bi-trophy-fill"></i> 1
                                                                </span>
                                                            @elseif($index == 1)
                                                                <span class="badge" style="background: linear-gradient(45deg, #C0C0C0, #808080); font-size: 0.9rem;">
                                                                    <i class="bi bi-trophy"></i> 2
                                                                </span>
                                                            @elseif($index == 2)
                                                                <span class="badge" style="background: linear-gradient(45deg, #CD7F32, #8B4513); font-size: 0.9rem;">
                                                                    <i class="bi bi-trophy"></i> 3
                                                                </span>
                                                            @else
                                                                <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <strong>{{ $makanan->nama_makanan }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-primary" style="font-size: 0.9rem;">
                                                                <i class="bi bi-heart-fill"></i> {{ $makanan->total_likes }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i> 
                                            Data dihitung berdasarkan total like dari semua tanggal
                                        </small>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">Belum ada data like untuk makanan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-primary text-white">
                                <span class="avatar-content">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Info Akun</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="px-4 py-3">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-badge text-primary fs-4 me-3"></i>
                                <div>
                                    <h6 class="mb-0 font-bold">Role</h6>
                                    <p class="text-muted mb-0">
                                        @if(Auth::user()->roles->isNotEmpty())
                                            {{ Auth::user()->roles->first()->name }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @hasrole('Operator Sekolah')
                                @if($namaSekolah)
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-building text-success fs-4 me-3"></i>
                                        <div>
                                            <h6 class="mb-0 font-bold">Sekolah</h6>
                                            <p class="text-muted mb-0">{{ $namaSekolah }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endhasrole

                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check text-info fs-4 me-3"></i>
                                <div>
                                    <h6 class="mb-0 font-bold">Bergabung</h6>
                                    <p class="text-muted mb-0">{{ Auth::user()->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                @hasanyrole('Admin|Operator BGN')
                <div class="card">
                    <div class="card-header">
                        <h4>Statistik Program</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Total Sekolah</span>
                                <span class="font-bold">{{ $totalSekolah }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Total Siswa</span>
                                <span class="font-bold">{{ $totalSiswa }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Menu Makanan</span>
                                <span class="font-bold">{{ $totalMakanan }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endhasanyrole
            </div>
        </section>
    </div>
</x-app-layout>

