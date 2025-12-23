@section('title', 'Daftar Kategori Makanan')

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
            <x-table-card :title="'Daftar Kategori Makanan'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('kategori-makanans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Makanan</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @forelse ($kategoriMakanans as $kategori)
                        <tr>
                            <td>{{ $kategori->id }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td>{{ Str::limit($kategori->deskripsi, 50) }}</td>
                            <td>{{ $kategori->makanans_count }} makanan
                            </td>
                            <td>
                                <a href="{{ route('kategori-makanans.show', $kategori->id) }}" class="btn btn-light-info me-2 mb-2">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                                <a href="{{ route('kategori-makanans.edit', $kategori->id) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('kategori-makanans.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data kategori makanan.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $kategoriMakanans->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
