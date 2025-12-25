@section('title', 'Tambah Jadwal Menu')

<x-app-layout>
    <x-form-card :title="'Form Tambah Jadwal Menu'" :backLink="route('jadwal-menus.index')">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('jadwal-menus.store') }}" method="POST">
            @csrf

            @if(auth()->user()->hasRole('Admin'))
                <div class="form-group">
                    <label for="sppg_id">SPPG <span class="text-danger">*</span></label>
                    <select name="sppg_id" id="sppg_id" class="form-control" required>
                        <option value="">Pilih SPPG</option>
                        @foreach($sppgs as $sppg)
                            <option value="{{ $sppg->id }}" {{ old('sppg_id', $sppgId) == $sppg->id ? 'selected' : '' }}>
                                {{ $sppg->nama_dapur }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <h5>Pilih Menu untuk Setiap Hari <span class="text-danger">*</span></h5>
            <p class="text-muted small">Pilih satu menu dari setiap kategori untuk setiap hari (Senin - Jumat).</p>

            <div class="accordion accordion-flush" id="accordionDays">
                @php
                    $hariOptions = [
                        'senin' => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu' => 'Rabu',
                        'kamis' => 'Kamis',
                        'jumat' => 'Jumat'
                    ];
                @endphp

                @foreach($hariOptions as $hariKey => $hariLabel)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $hariKey }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $hariKey }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $hariKey }}">
                                <strong>{{ $hariLabel }}</strong>
                            </button>
                        </h2>
                        <div id="collapse-{{ $hariKey }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $hariKey }}" data-bs-parent="#accordionDays">
                            <div class="accordion-body">
                                @foreach($kategoriMenus as $kategori)
                                    <div class="form-group">
                                        <label for="menu_{{ $hariKey }}_{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="menus[{{ $hariKey }}][{{ $kategori->id }}]" id="menu_{{ $hariKey }}_{{ $kategori->id }}" class="form-control" required>
                                            <option value="">Pilih {{ $kategori->nama_kategori }}</option>
                                            @foreach($kategori->menus as $menu)
                                                <option value="{{ $menu->id }}" {{ old("menus.{$hariKey}.{$kategori->id}") == $menu->id ? 'selected' : '' }}>
                                                    {{ $menu->nama_menu }}
                                                    @if($menu->deskripsi)
                                                        - {{ Str::limit($menu->deskripsi, 50) }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </div>
        </form>
    </x-form-card>
</x-app-layout>
