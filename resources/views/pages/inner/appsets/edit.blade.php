@section('title', 'Ubah Application Set')

<x-app-layout>
    <x-form-card :title="'Setting'" :backLink="route('dashboard')">

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

        <form action="{{ route('appsets.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Fields for Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $appset->name }}" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" class="form-control" id="address" required>{{ $appset->address }}</textarea>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $appset->email }}" required>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $appset->phone_number }}" required>
            </div>

            <!-- Facebook -->
            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" class="form-control" id="facebook" value="{{ $appset->facebook }}">
            </div>

            <!-- Instagram -->
            <div class="form-group">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" class="form-control" id="instagram" value="{{ $appset->instagram }}">
            </div>

            <!-- Twitter -->
            <div class="form-group">
                <label for="twitter">Twitter</label>
                <input type="text" name="twitter" class="form-control" id="twitter" value="{{ $appset->twitter }}">
            </div>

            <!-- Brand Image -->
            <div class="form-group">
                <label for="brand_image">Brand Image</label>
                <input type="file" name="brand_image" class="form-control" id="brand_image">
                @if($appset->brand_image)
                    <div class="mt-3">
                        <img id="imagePreview" src="{{ asset('storage/' . $appset->brand_image) }}" alt="{{ $appset->name }}" style="max-width: 200px;" />
                    </div>
                @else
                    <div class="mt-3">
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px;" />
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3">Update Application Set</button>
        </form>
    </x-form-card>

    <script>
        // Image preview functionality
        document.getElementById('brand_image').addEventListener('change', function(event) {
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
