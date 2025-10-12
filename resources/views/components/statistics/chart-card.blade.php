<!-- resources/views/components/chart-card.blade.php -->
@props([
    'title',
])

<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
