@section('title', 'Kelola Sekolah Zona Pengantaran')

<x-app-layout>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kelola Sekolah Zona Pengantaran</h3>
                    <p class="text-subtitle text-muted">Kelola sekolah yang dilayani oleh {{ $sppg->nama_dapur }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sppg.edit') }}">Data Dapur</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Sekolah</li>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Tambah Sekolah ke Zona Pengantaran
                    </h5>
                </div>
                <div class="card-body">
                    @if($availableSekolahs->count() > 0)
                        <form action="{{ route('sppg.sekolahs.attach') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-5">
                                <label for="sekolah_id" class="form-label">Pilih Sekolah</label>
                                <select name="sekolah_id" id="sekolah_id" class="form-select" required>
                                    <option value="">-- Pilih Sekolah --</option>
                                    @foreach($availableSekolahs as $sekolah)
                                        <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }} - {{ $sekolah->alamat_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="zona" class="form-label">Zona Pengantaran</label>
                                <input type="text" name="zona" id="zona" class="form-control" 
                                       placeholder="Contoh: Zona A, Zona Utara, dll" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Tambah</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Semua sekolah sudah ditambahkan atau belum ada sekolah yang terdaftar.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Sekolah yang Dilayani</h5>
                </div>
                <div class="card-body">
                    @if($sekolahs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th>Alamat</th>
                                        <th>Zona Pengantaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sekolahs as $index => $sekolah)
                                        <tr>
                                            <td>{{ $sekolahs->firstItem() + $index }}</td>
                                            <td>{{ $sekolah->nama_sekolah }}</td>
                                            <td>{{ $sekolah->alamat_sekolah }}</td>
                                            <td>
                                                <form action="{{ route('sppg.sekolahs.update', $sekolah->id) }}" method="POST" class="d-inline-flex gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="zona" value="{{ $sekolah->zona }}" 
                                                           class="form-control form-control-sm" style="width: 150px;" required>
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('sppg.sekolahs.detach', $sekolah->id) }}" method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini dari zona pengantaran?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $sekolahs->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada sekolah yang ditambahkan ke zona pengantaran.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
