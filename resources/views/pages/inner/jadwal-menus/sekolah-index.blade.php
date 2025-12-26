@section('title', 'Jadwal Menu Sekolah')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Jadwal Menu</h4>
                            <p class="text-muted mb-0">
                                <i class="bi bi-building me-1"></i> {{ $sekolah->nama_sekolah ?? 'Sekolah' }}
                                @if($sekolah && $sekolah->sppg)
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-shop me-1"></i> SPPG: {{ $sekolah->sppg->nama_dapur }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(empty($jadwalData))
                        <div class="alert alert-light-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Belum ada jadwal menu.</strong>
                            <p class="mb-0 mt-2">Jadwal menu akan ditampilkan di sini setelah diatur oleh SPPG Anda.</p>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionJadwal">
                            @foreach($jadwalData as $index => $periode)
                                <div class="accordion-item border rounded mb-3">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-calendar-range me-2 text-primary"></i>
                                                <strong>
                                                    @if($periode['tanggal_mulai'] && $periode['tanggal_selesai'])
                                                        Periode: {{ $periode['tanggal_mulai']->format('d/m/Y') }} - {{ $periode['tanggal_selesai']->format('d/m/Y') }}
                                                    @else
                                                        Periode: Belum ditentukan
                                                    @endif
                                                </strong>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionJadwal">
                                        <div class="accordion-body">
                                            @php
                                                $hariOptions = [
                                                    'senin' => 'Senin',
                                                    'selasa' => 'Selasa',
                                                    'rabu' => 'Rabu',
                                                    'kamis' => 'Kamis',
                                                    'jumat' => 'Jumat'
                                                ];
                                                
                                                // Get all unique categories from all days
                                                $allKategories = collect();
                                                foreach($hariOptions as $hariKey => $hariLabel) {
                                                    $jadwalHari = $periode['jadwals']->get($hariKey);
                                                    if ($jadwalHari && $jadwalHari->details->isNotEmpty()) {
                                                        foreach($jadwalHari->details as $detail) {
                                                            if (!$allKategories->contains('id', $detail->kategoriMenu->id)) {
                                                                $allKategories->push($detail->kategoriMenu);
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="15%" class="text-center align-middle">Kategori</th>
                                                            @foreach($hariOptions as $hariKey => $hariLabel)
                                                                <th class="text-center" width="17%">
                                                                    <strong class="text-primary">{{ $hariLabel }}</strong>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($allKategories as $kategori)
                                                            <tr>
                                                                <td class="align-middle text-center">
                                                                    <strong class="text-primary">{{ $kategori->nama_kategori }}</strong>
                                                                </td>
                                                                @foreach($hariOptions as $hariKey => $hariLabel)
                                                                    @php
                                                                        $jadwalHari = $periode['jadwals']->get($hariKey);
                                                                        $menuForKategori = null;
                                                                        if ($jadwalHari && $jadwalHari->details->isNotEmpty()) {
                                                                            $menuForKategori = $jadwalHari->details->firstWhere('kategori_menu_id', $kategori->id);
                                                                        }
                                                                    @endphp
                                                                    <td class="align-middle">
                                                                        @if($menuForKategori)
                                                                            <div>
                                                                                <strong class="d-block">{{ $menuForKategori->menu->nama_menu }}</strong>
                                                                                @if($menuForKategori->menu->deskripsi_menu)
                                                                                    <small class="text-muted">{{ Str::limit($menuForKategori->menu->deskripsi_menu, 50) }}</small>
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                        @if($allKategories->isEmpty())
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">
                                                                    <i class="bi bi-dash-circle me-1"></i>Belum ada menu untuk periode ini
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
