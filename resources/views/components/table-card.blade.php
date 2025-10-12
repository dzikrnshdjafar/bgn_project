<link rel="stylesheet" href="{{ asset('mzr') }}/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="{{ asset('mzr') }}/assets/compiled/css/table-datatable.css">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        {{ $headerActions ?? '' }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    {{ $tableHeader }}
                </thead>
                <tbody>
                    {{ $tableBody }}
                </tbody>
            </table>
        </div>
    </div>
</div>    
    <script src="{{ asset('mzr') }}/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="{{ asset('mzr') }}/assets/static/js/pages/simple-datatables.js"></script>
