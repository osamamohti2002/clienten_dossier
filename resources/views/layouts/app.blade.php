<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ZorgSysteem</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Logo image styling */
        .logo-img {
            height: 2.5rem;
            width: auto;
            margin-right: 0.75rem;
            object-fit: contain;
        }
        
        /* Responsive logo adjustments */
        @media (max-width: 640px) {
            .logo-img {
                height: 2rem; /* Slightly smaller on mobile */
                margin-right: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    @if (auth()->user()->role_id === 2)
        @include('layouts.navbars.plannerNav')
    @elseif (auth()->user()->role_id === 3)
        @include('layouts.navbars.zorgNav')
    @elseif (auth()->user()->role_id === 1)
        @include('layouts.navbars.adminNav')
    @endif
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      @yield('content')
    </main>

</body>
</html>