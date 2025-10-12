<header class="bg-primary shadow-md">
  <nav class="fixed top-0 left-0 w-full z-50 transition-colors duration-300 bg-neutral backdrop-blur-none">
      <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="text-white text-3xl font-bold">
          <a href="#home">
            <img src="{{ asset('storage') }}/{{ $appset->brand_image }}" alt="Brand Logo" class="w-full h-10" />
          </a>
        </div>
    
        <!-- Hamburger Icon (Mobile Only) -->
        <div class="md:hidden">
          <button
            id="hamburgerButton"
            class="text-white text-3xl focus:outline-none"
          >
            ☰
          </button>
        </div>
    
        <!-- Links (Desktop & Mobile) -->
        <div
          id="navMenu"
          class="hidden flex-col md:flex md:flex-row md:space-x-6 text-lg absolute md:relative top-16 md:top-0 left-0 w-full md:w-auto bg-neutral md:bg-transparent text-white items-center transition-all duration-300 md:transition-none"
        >
          <a href="#home" class="block py-2 px-4 hover:text-gray-300 transition">Home</a>
          <a href="#katalog" class="block py-2 px-4 hover:text-gray-300 transition">Katalog</a>
          <a href="#pricelist" class="block py-2 px-4 hover:text-gray-300 transition">Pricelist</a>
          <a href="#info" class="block py-2 px-4 hover:text-gray-300 transition">Info</a>
          @if (Route::has('login'))
          @auth
          <a href="{{ url('/dashboard') }}" class="block py-2 px-4 hover:text-gray-300 transition">Dashboard</a>
          @else
          <a href="{{ route('login') }}" class="block py-2 px-4 hover:text-gray-300 transition">Log in</a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="block py-2 px-4 hover:text-gray-300 transition">Register</a>
          @endif 
          @endauth
          @endif
        </div>
      </div>
    </nav>          
    <script src="{{ asset('landpage') }}/src/js/navbar.js"></script>               
</header>