@section('title', 'Detail Siswa')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Siswa</h4>
                    <a href="{{ route('siswas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">NIS:</div>
                        <div class="col-md-9">{{ $siswa->nis }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Nama Siswa:</div>
                        <div class="col-md-9">{{ $siswa->nama_siswa }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Sekolah:</div>
                        <div class="col-md-9">{{ $siswa->sekolah->nama_sekolah ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Alamat Sekolah:</div>
                        <div class="col-md-9">{{ $siswa->sekolah->alamat_sekolah ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Makanan Kesukaan:</div>
                        <div class="col-md-9">{{ $siswa->makananKesukaan->nama_makanan ?? '-' }}</div>
                    </div>
                    @if($siswa->makananKesukaan && $siswa->makananKesukaan->deskripsi)
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Deskripsi Makanan:</div>
                            <div class="col-md-9">{{ $siswa->makananKesukaan->deskripsi }}</div>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status Kehadiran:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $siswa->kehadiran ? 'success' : 'secondary' }}">
                                {{ $siswa->kehadiran ? 'Hadir' : 'Tidak Hadir' }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Dibuat:</div>
                        <div class="col-md-9">{{ $siswa->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Diperbarui:</div>
                        <div class="col-md-9">{{ $siswa->updated_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('siswas.edit', $siswa->nis) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('siswas.destroy', $siswa->nis) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                <i class="bi bi-trash3 me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

