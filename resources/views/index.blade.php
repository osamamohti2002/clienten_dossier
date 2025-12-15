<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZorgSysteem - Login</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <img src="media/logo/ZorgSysteem_logo.png" alt="ZorgSysteem Logo" class="h-20 mb-3 drop-shadow-md">
            <h2 class="text-3xl font-bold text-gray-900">ZorgSysteem</h2>
            <p class="text-gray-500 text-sm mt-1">Inloggen op uw account</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Email -->
            <div>
                <label class="font-medium text-gray-700">E-mailadres</label>
                <input type="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-50 
                           focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="voorbeeld@zorgsysteem.nl"
                    required>
            </div>

            <!-- Password -->
            <div>
                <label class="font-medium text-gray-700">Wachtwoord</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-50 
                           focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="••••••••"
                    required>
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold
                       hover:bg-blue-700 transition shadow">
                Inloggen
            </button>
        </form>


    </div>

</body>
</html>
