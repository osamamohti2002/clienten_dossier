@extends('layouts.app')

@section('content')
<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Nieuwe medewerker</h1>
            <p class="text-gray-600">Voeg een nieuwe medewerker toe aan het systeem</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form id="add-employee-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Voornaam -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Voornaam *
                        </label>
                        <input type="text" required 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            E-mailadres *
                        </label>
                        <input type="email" required 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Wachtwoord -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord *
                        </label>
                        <input type="password" required 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Minimaal 8 karakters</p>
                    </div>

                    <!-- Wachtwoord bevestigen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord bevestigen *
                        </label>
                        <input type="password" required 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol *
                        </label>
                        <select class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            <option value="zorgpersoneel" selected>Zorgpersoneel</option>
                            <option value="planner">Planner</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Annuleren
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fa fa-user-plus mr-2"></i>Medewerker aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-employee-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Medewerker aangemaakt!');
            // In een echte app zou je hier een fetch/POST doen
        });
    </script>
</body>
@endsection