<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jukebox</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
</head>
<body class="bg-[#ffffff] flex flex-col min-h-full">

  <!-- Navbar -->
  {{-- @guest
      @include('layouts.nav-bars.mainNavBar')
  @endguest


  @auth
    @include('layouts.nav-bars.userNavBar')
  @endauth --}}


  <main class="flex-grow">
    {{-- @include('shared._flash') --}}
    @yield('content')

  </main>

<!-- Footer -->
<footer class="bg-[#111111] text-white text-center py-4">
    <p class="text-sm">© Clienten Dossier 2025</p>
</footer>

</body>
</html>
