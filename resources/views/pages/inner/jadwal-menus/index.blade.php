@section('title', 'Jadwal Menu Management')

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
            <x-table-card :title="'Daftar Jadwal Menu'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('jadwal-menus.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal Menu
                        </a>
                        <a href="{{ route('jadwal-menus.export-pdf') }}" class="btn btn-success" target="_blank">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Ekspor PDF
                        </a>
                        @if(auth()->user()->hasRole('Admin|Operator BGN'))
                            <form action="{{ route('distribusi.generate') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-info" onclick="return confirm('Generate data distribusi untuk semua sekolah berdasarkan jadwal menu yang aktif?')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Generate Semua Distribusi
                                </button>
                            </form>
                        @endif
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>No</th>
                        @if(auth()->user()->hasRole('Admin|Operator BGN'))
                            <th>SPPG</th>
                        @endif
                        <th>Periode</th>
                        <th>Jadwal Menu (Senin - Jumat)</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @php
                        // Group jadwal by sppg_id and periode
                        $groupedJadwals = $jadwalMenus->groupBy(function($item) {
                            return $item->sppg_id . '|' . ($item->tanggal_mulai?->format('Y-m-d') ?? 'null') . '|' . ($item->tanggal_selesai?->format('Y-m-d') ?? 'null');
                        });
                    @endphp
                    @forelse ($groupedJadwals as $key => $jadwalGroup)
                        @php
                            $firstJadwal = $jadwalGroup->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if(auth()->user()->hasRole('Admin|Operator BGN'))
                                <td>{{ $firstJadwal->sppg->nama_dapur }}</td>
                            @endif
                            <td>
                                @if($firstJadwal->tanggal_mulai && $firstJadwal->tanggal_selesai)
                                    {{ $firstJadwal->tanggal_mulai->format('d/m/Y') }} - {{ $firstJadwal->tanggal_selesai->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $hariLabels = [
                                        'senin' => 'Senin',
                                        'selasa' => 'Selasa',
                                        'rabu' => 'Rabu',
                                        'kamis' => 'Kamis',
                                        'jumat' => 'Jumat'
                                    ];
                                @endphp
                                <div class="accordion" id="accordion-{{ $loop->iteration }}">
                                    @foreach($hariLabels as $hariKey => $hariLabel)
                                        @php
                                            $jadwalHari = $jadwalGroup->firstWhere('hari', $hariKey);
                                        @endphp
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $loop->parent->iteration }}-{{ $hariKey }}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->parent->iteration }}-{{ $hariKey }}" aria-expanded="false" aria-controls="collapse-{{ $loop->parent->iteration }}-{{ $hariKey }}">
                                                    <strong>{{ $hariLabel }}</strong>
                                                    @if(!$jadwalHari)
                                                        <span class="badge bg-light-secondary ms-2">Belum diatur</span>
                                                    @endif
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $loop->parent->iteration }}-{{ $hariKey }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $loop->parent->iteration }}-{{ $hariKey }}" data-bs-parent="#accordion-{{ $loop->parent->iteration }}">
                                                <div class="accordion-body">
                                                    @if($jadwalHari)
                                                        @foreach($jadwalHari->details as $detail)
                                                            <div class="mb-2">
                                                                <strong class="text-primary">{{ $detail->kategoriMenu->nama_kategori }}:</strong> 
                                                                {{ $detail->menu->nama_menu }}
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted mb-0">Menu belum diatur untuk hari ini.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('jadwal-menus.edit', $firstJadwal) }}" class="btn btn-light-warning btn-sm">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-light-danger btn-sm" onclick="confirmDeleteGroup({{ $loop->iteration }})">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                    
                                    <!-- Generate Distribusi Button -->
                                    <form action="{{ route('distribusi.generate-by-sppg', $firstJadwal->sppg_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Generate data distribusi untuk semua sekolah di SPPG ini?')" title="Generate Distribusi">
                                            <i class="bi bi-arrow-repeat me-1"></i> Generate
                                        </button>
                                    </form>
                                    
                                    <!-- Cancel Distribusi Button -->
                                    <form action="{{ route('distribusi.cancel-by-sppg', $firstJadwal->sppg_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Batalkan semua distribusi yang belum diterima untuk SPPG ini?')" title="Batalkan Distribusi">
                                            <i class="bi bi-x-circle me-1"></i> Batalkan
                                        </button>
                                    </form>
                                </div>
                                
                                <div id="delete-forms-{{ $loop->iteration }}" style="display:none;">
                                    @foreach($jadwalGroup as $jadwal)
                                        <form action="{{ route('jadwal-menus.destroy', $jadwal) }}" method="POST" id="delete-form-{{ $loop->iteration }}-{{ $jadwal->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('Admin|Operator BGN') ? 5 : 4 }}" class="text-center">Tidak ada data jadwal menu.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $jadwalMenus->links() }}
            </div>
        </div>
    </section>

    <script>
    function confirmDeleteGroup(rowIndex) {
        if (confirm('Yakin ingin menghapus semua jadwal menu (Senin-Jumat) untuk periode ini?')) {
            // Find all forms in the group and submit them
            const forms = document.querySelectorAll(`form[id^="delete-form-${rowIndex}-"]`);
            let formSubmitted = false;
            forms.forEach(form => {
                if (!formSubmitted) {
                    form.submit();
                    formSubmitted = true;
                }
            });
        }
    }
    </script>
</x-app-layout>
