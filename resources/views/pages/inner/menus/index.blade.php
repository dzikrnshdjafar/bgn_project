@section('title', 'Menu Management')

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
            <x-table-card :title="'Daftar Menu'">
                <x-slot name="headerActions">
                    @hasanyrole('Admin|Operator BGN')
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('menus.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
                        </a>
                    </div>
                    @endhasanyrole
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        @hasanyrole('Admin|Operator BGN')
                        <th>Aksi</th>
                        @endhasanyrole
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @forelse ($menus as $key => $menu)
                        <tr>
                            <td>{{ $menus->firstItem() + $key }}</td>
                            <td>{{ $menu->nama_menu ?? '-' }}</td>
                            <td>{{ $menu->kategoriMenu->nama_kategori ?? '-' }}</td>
                            <td>{{ Str::limit($menu->deskripsi, 50) ?? '-' }}</td>
                            @hasanyrole('Admin|Operator BGN')
                            <td>
                                <a href="{{ route('menus.edit', $menu) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                            @endhasanyrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data menu.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $menus->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
