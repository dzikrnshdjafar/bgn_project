@section('title', 'Tambah Item')

<x-app-layout>
    <x-form-card :title="'Form Tambah Item'" :backLink="route('items.index')">

        <!-- Flash Messages for Success and Error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Fields for Name, Description, Condition, Category, and Image -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
            </div>            

            <div class="form-group">
                <label for="image">Upload Gambar</label>
                <input type="file" name="image" class="form-control" id="image" required>
                <div class="mt-3">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px;" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Add Item</button>
        </form>
    </x-form-card>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = "#";
                imagePreview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
