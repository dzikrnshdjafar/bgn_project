<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-neutral sans-serif">
        <!-- Navbar -->
        @include('layouts.outer.navbar')
        
        <!-- Hero Section -->
        <section class="bg-primary text-slate text-center"  style="background-image: url('{{ asset('landpage') }}/assets/image/bgimage2.jpeg');">
            <div class="container mx-auto h-screen justify-center items-center flex flex-col">
                <h2 class="sm:text-7xl text-3xl font-bold text-secondary">Welcome to {{ $appset->name }}</h2>
                <p class="mt-4 text-lg text-slate">We provide the best solutions for your business.</p>
                <a href="#features" class="mt-8 inline-block bg-secondary text-primary px-6 py-3 rounded-lg font-medium shadow-lg hover:bg-sechov">Learn More</a>
            </div>
        </section>
        
        <!-- Features Section -->
        <section id="features" class="py-16 bg-neutral">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-3xl font-bold text-secondary">Our Features</h3>
                <p class="mt-2 text-slate">What makes us unique</p>
                <!-- Tempat untuk Data -->
                <div id="feature-container" class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Data dari API akan muncul di sini -->
                </div>
                <script type="module" src="src/js/fetchFeature.js"></script>
            </div>
        </section>
    
        <!-- <section id="pricelist" class="py-16 flex items-center justify-center">
          <div class="flex flex-col px-4 text-center items-center rounded-xl bg-slate w-2/5">
            <h3 class="text-3xl font-bold text-primary">Pricelist</h3>
            <div class="w-full flex flex-col p-2">
              <table id="pricelist-table" class="display rounded-xl bg-emerald">
                <thead>
                  <tr>
                    <th>Ukuran Baju</th>
                    <th>Ukuran Logo</th>
                    <th>Jenis Sablon</th>
                    <th>Harga</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              
            </div>
            <script type="module" src="/src/js/fetchPriceList.js"></script>
          </div>
        </section> -->
        
    
      <!-- About Section -->
      <section id="about" class="py-16">
        <div class="container mx-auto px-4">
          <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
              <img src="{{ asset('landpage') }}/assets/logo/brand.svg" alt="About Us" class="rounded-lg shadow-md">
            </div>
            <div class="md:w-1/2 md:pl-8 mt-8 md:mt-0">
              <h3 class="text-3xl font-bold text-secondary">About Us</h3>
              <p class="mt-4 text-slate">We are a company committed to providing top-notch solutions for our customers.</p>
            </div>
          </div>
        </div>
      </section>
    
      <!-- Contact Section -->
      <section id="contact" class="py-16 bg-emerald">
        <div class="container mx-auto px-4 text-center">
          <h3 class="text-3xl font-bold text-primary">Contact Us</h3>
          <p class="mt-2 text-primary">Get in touch with us</p>
          <form class="mt-8 max-w-md mx-auto">
            <input type="text" placeholder="Your Name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary mb-4">
            <input type="email" placeholder="Your Email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary mb-4">
            <textarea placeholder="Your Message" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary mb-4"></textarea>
            <button type="submit" class="w-full bg-secondary text-primary px-4 py-2 rounded-lg font-medium hover:bg-sechov">Send Message</button>
          </form>
        </div>
      </section>
    
      <!-- Footer -->
      @include("layouts.outer.footer")
      
    <a href="https://wa.me/{{ $appset->phone_number }}" target="_blank" class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-full shadow-lg flex items-center space-x-2">
        <img src="{{ asset('landpage') }}/assets/logo/whatsapp.svg" alt="WhatsApp" class="w-full h-full">
      </a>
    </body>
</html>
