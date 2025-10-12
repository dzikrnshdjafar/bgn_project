<!-- resources/views/components/statistics/info-card.blade.php -->
@props([
    'title',
    'value',
    'iconColor',
    'iconClass'
])

<div class="col-6 col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body px-4 py-4-5">
            <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon {{ $iconColor }} mb-2">
                        <i class="{{ $iconClass }}"></i>
                    </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h5 class="text-muted font-semibold">{{ $title }}</h5>
                    <h5 class="font-extrabold mb-0">{{ $value }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
