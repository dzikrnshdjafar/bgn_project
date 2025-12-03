@section('title', 'Daftar Siswa')

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
            <x-table-card :title="'Daftar Siswa'">
                <x-slot name="headerActions">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('siswas.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                        </a>
                    </div>
                </x-slot>
                <x-slot name="tableHeader">
                    <tr>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Sekolah</th>
                        <th>Makanan Kesukaan</th>
                        <th>Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="tableBody">
                    @forelse ($siswas as $siswa)
                        <tr>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama_siswa }}</td>
                            <td>{{ $siswa->sekolah->nama_sekolah ?? '-' }}</td>
                            <td>{{ $siswa->makananKesukaan->nama_makanan ?? '-' }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input kehadiran-toggle" type="checkbox" 
                                           id="kehadiran-{{ $siswa->nis }}" 
                                           data-nis="{{ $siswa->nis }}"
                                           {{ $siswa->kehadiran ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kehadiran-{{ $siswa->nis }}">
                                        <span class="badge bg-{{ $siswa->kehadiran ? 'success' : 'secondary' }}" id="badge-{{ $siswa->nis }}">
                                            {{ $siswa->kehadiran ? 'Hadir' : 'Tidak Hadir' }}
                                        </span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('siswas.show', $siswa->nis) }}" class="btn btn-light-info me-2 mb-2">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                                <a href="{{ route('siswas.edit', $siswa->nis) }}" class="btn btn-light-warning me-2 mb-2">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('siswas.destroy', $siswa->nis) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger mb-2" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table-card>
            <div class="mt-4">
                {{ $siswas->links() }}
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle toggle kehadiran
            const toggles = document.querySelectorAll('.kehadiran-toggle');
            
            console.log('Found toggles:', toggles.length);
            
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const nis = this.dataset.nis;
                    const isChecked = this.checked;
                    const badge = document.getElementById('badge-' + nis);
                    
                    console.log('Toggle clicked for NIS:', nis, 'Checked:', isChecked);
                    
                    // Disable toggle sementara
                    this.disabled = true;
                    
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token not found!');
                        alert('CSRF token tidak ditemukan. Harap refresh halaman.');
                        this.checked = !isChecked;
                        this.disabled = false;
                        return;
                    }
                    
                    // Send AJAX request
                    fetch(`/siswas/${nis}/toggle-kehadiran`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            // Update badge
                            if (data.kehadiran) {
                                badge.classList.remove('bg-secondary');
                                badge.classList.add('bg-success');
                                badge.textContent = 'Hadir';
                            } else {
                                badge.classList.remove('bg-success');
                                badge.classList.add('bg-secondary');
                                badge.textContent = 'Tidak Hadir';
                            }
                        } else {
                            // Revert toggle if failed
                            this.checked = !isChecked;
                            alert(data.message || 'Gagal mengubah status kehadiran');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert toggle on error
                        this.checked = !isChecked;
                        alert('Terjadi kesalahan saat mengubah status kehadiran: ' + error.message);
                    })
                    .finally(() => {
                        // Re-enable toggle
                        this.disabled = false;
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
