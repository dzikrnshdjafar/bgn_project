@section('title', 'User Management')

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
            <x-table-card :title="'Daftar Pengguna'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <span class="badge bg-success">{{ $v }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
