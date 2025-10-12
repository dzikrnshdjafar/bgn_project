@section('title', 'Tambah Pengguna')

<x-app-layout>
    <x-form-card :title="'Form Tambah Pengguna'" :backLink="route('users.index')">
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

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <h5>Data Pengguna</h5>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="sekolah-fields" style="display: none;">
                <h5 class="mt-4">Data Sekolah</h5>
                <div class="form-group">
                    <label for="nama_sekolah">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" class="form-control" id="nama_sekolah" value="{{ old('nama_sekolah') }}">
                </div>
                <div class="form-group">
                    <label for="alamat_sekolah">Alamat Sekolah</label>
                    <input type="text" name="alamat_sekolah" class="form-control" id="alamat_sekolah" value="{{ old('alamat_sekolah') }}">
                </div>
            </div>

            <div id="sppg-fields" style="display: none;">
                <h5 class="mt-4">Data SPPG</h5>
                <div class="form-group">
                    <label for="nama_dapur">Nama Dapur</label>
                    <input type="text" name="nama_dapur" class="form-control" id="nama_dapur" value="{{ old('nama_dapur') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" value="{{ old('alamat') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Tambah Pengguna</button>
        </form>
    </x-form-card>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            var role = this.value;
            var sekolahFields = document.getElementById('sekolah-fields');
            var sppgFields = document.getElementById('sppg-fields');

            if (role === 'Operator Sekolah') {
                sekolahFields.style.display = 'block';
                sppgFields.style.display = 'none';
            } else if (role === 'Operator SPPG') {
                sekolahFields.style.display = 'none';
                sppgFields.style.display = 'block';
            } else {
                sekolahFields.style.display = 'none';
                sppgFields.style.display = 'none';
            }
        });

        // Trigger change event on page load to show fields if a role is already selected
        document.getElementById('role').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
