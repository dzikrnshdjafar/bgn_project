@section('title', 'Daftar Makanan')

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
            <x-table-card :title="'Daftar Makanan'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('makanans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Makanan
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Nama Makanan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @foreach ($makanans as $makanan)
                        <tr>
                            <td>{{ $makanan->id }}</td>
                            <td>{{ $makanan->nama_makanan }}</td>
                            <td>{{ Str::limit($makanan->deskripsi, 50) }}</td>
                            <td>
                                <a href="{{ route('makanans.show', $makanan->id) }}" class="btn btn-light-info me-2 mb-2">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                                <a href="{{ route('makanans.edit', $makanan->id) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('makanans.destroy', $makanan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Are you sure you want to delete this makanan?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $makanans->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
