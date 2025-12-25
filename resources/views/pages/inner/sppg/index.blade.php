@section('title', 'Kelola SPPG')

<x-app-layout>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kelola SPPG</h3>
                    <p class="text-subtitle text-muted">Kelola semua dapur SPPG dan sekolah yang dilayani</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola SPPG</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar SPPG</h5>
                </div>
                <div class="card-body">
                    @if($sppgs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dapur</th>
                                        <th>Alamat</th>
                                        <th>Operator</th>
                                        <th>Jumlah Sekolah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sppgs as $index => $sppg)
                                        <tr>
                                            <td>{{ $sppgs->firstItem() + $index }}</td>
                                            <td>{{ $sppg->nama_dapur }}</td>
                                            <td>{{ $sppg->alamat }}</td>
                                            <td>{{ $sppg->user->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $sppg->sekolahs->count() }} Sekolah
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.sppgs.sekolahs', $sppg->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="bi bi-building"></i> Kelola Sekolah
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $sppgs->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada SPPG yang terdaftar.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
