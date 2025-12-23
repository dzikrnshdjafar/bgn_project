@section('title', 'Daftar Sekolah SPPG')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <x-table-card 
                title="Daftar Sekolah {{ $dapurSehat->nama_dapur }}" 
                :data="$sekolahs"
            >
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('sppg-sekolah.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Sekolah
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Nama Sekolah</th>
                        <th>Alamat</th>
                        <th>Operator</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @foreach ($sekolahs as $sekolah)
                        <tr>
                            <td>{{ $sekolah->id }}</td>
                            <td>{{ $sekolah->nama_sekolah }}</td>
                            <td>{{ $sekolah->alamat_sekolah }}</td>
                            <td>{{ $sekolah->user->name ?? '-' }}</td>
                            <td>{{ $sekolah->jumlah_siswa }}</td>
                            <td>
                                <form action="{{ route('sppg-sekolah.destroy', $sekolah->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Yakin ingin menghapus sekolah ini dari daftar SPPG?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $sekolahs->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
