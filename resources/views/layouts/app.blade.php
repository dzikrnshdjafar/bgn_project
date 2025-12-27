<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Mazer Admin Dashboard</title>

    <link rel="shortcut icon" href="{{ asset('landpage') }}/asset/logonotext.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('mzr') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('mzr') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('mzr') }}/assets/compiled/css/iconly.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('mzr') }}/assets/extensions/@fortawesome/fontawesome-free/css/all.min.css">
    <script>
        tailwind.config = {
          prefix: 'tw-',
        }
      </script>
    
</head>
<body>
    <script src="{{ asset('mzr') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        @include('layouts.sidebar', ['pendingLoansCount' => $pendingLoansCount ?? 0])
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading d-flex align-items-center">
                <h3>@yield('title', 'Dashboard')</h3>
                <div class="dropdown ms-auto">
                    Hello,
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <div class="px-4 py-2">
                            <div class="font-medium"><code>{{ Auth::user()->email }}</code></div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                            @csrf
                            <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="page-content"> 
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
    <script src="{{ asset('mzr') }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset('mzr') }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('mzr') }}/assets/compiled/js/app.js"></script>
    
    <!-- Need: Apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    @stack('scripts')
</body>
</html>
