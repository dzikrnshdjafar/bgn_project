@section('title', 'Jadwal Menu')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Jadwal Menu Mingguan - {{ $dapurSehat->nama_dapur }}</h4>
                    <p class="text-muted mb-0">Jadwal menu berlaku untuk semua sekolah yang terdaftar di SPPG ini</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">Hari</th>
                                    <th>Menu Makanan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwalMenus as $jadwal)
                                    <tr>
                                        <td>
                                            {{ $jadwal->hari }}
                                        </td>
                                        <td>
                                            @if($jadwal->makanans->count() > 0)
                                                @foreach($jadwal->makanans as $makanan)
                                                    <span class="badge bg-secondary me-1 mb-1">{{ $makanan->nama_makanan }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted"><em>Belum ada menu</em></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal-menu.edit', $jadwal->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil me-1"></i> Edit Menu
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Tidak ada data jadwal menu
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
