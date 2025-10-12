@props(['item'])

<x-detail-modal :modalId="'itemModal'.$item->id" :modalTitle="$item->name">
    <x-slot name="slot">
        @if ($item->image)
    <div class="mb-3 text-center">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid d-block mx-auto">
    </div>
@endif


        <p><strong>Deskripsi: </strong>{{ $item->description ?? 'No description available' }}</p>

        <p><strong>Kuantitas dalam ruangan: </strong></p>
        <ul>
            
        </ul>
    </x-slot>

    <x-slot name="footer">
        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </x-slot>
</x-detail-modal>
