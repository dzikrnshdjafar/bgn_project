@section('title', 'Item')

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
            <x-table-card :title="'Daftar Item'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('items.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Item
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <!-- Trigger for Detail Modal -->
                                <button type="button" class="btn btn-light-info me-2 mb-2" data-bs-toggle="modal" data-bs-target="#itemModal{{ $item->id }}">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </button>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Are you sure you want to delete this item?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @include('pages.inner.items.show', ['item' => $item])
                    @endforeach
                </x-slot>
            </x-table-card>
        </div>
    </section>
</x-app-layout>
