@section('title', 'Ubah Barang')

<x-app-layout>
    <x-form-card :title="'Ubah Barang'" :backLink="route('items.index')">

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
        
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Fields for Name, Description, Condition, Category, and Image -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $item->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description">{{ $item->description }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image" class="form-control" id="image">
                @if($item->image)
                    <div class="mt-3">
                        <img id="imagePreview" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 200px;" />
                    </div>
                @else
                    <div class="mt-3">
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px;" />
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Item</button>
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
