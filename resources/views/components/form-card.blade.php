<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        @isset($backLink)
            <a href="{{ $backLink }}" class="btn  rounded-pill"><i class="bi bi-chevron-left"></i></a>
        @endisset
        <h5 class="card-title mb-0">{{ $title }}</h5>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
