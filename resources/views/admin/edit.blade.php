@extends('layouts.app')

@section('content')
<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Medewerker bewerken</h1>
            <p class="text-gray-600">Wijzig de gegevens van Mark de Jong</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form id="edit-employee-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Naam -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Volledige naam *
                        </label>
                        <input type="text" value="Mark de Jong" 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            E-mailadres *
                        </label>
                        <input type="email" value="m.dejong@zorgsysteem.nl" 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol *
                        </label>
                        <select class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            <option value="zorgpersoneel">Zorgpersoneel</option>
                            <option value="planner" selected>Planner</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <!-- Telefoon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Telefoonnummer
                        </label>
                        <input type="tel" value="06-12345678" 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Wachtwoord (alleen tonen bij wijzigen) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord
                        </label>
                        <input type="password" placeholder="Laat leeg om niet te wijzigen" 
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Vul alleen in om wachtwoord te wijzigen</p>
                    </div>

                    <!-- Actief Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Account status
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="active" checked 
                                       class="h-4 w-4 text-blue-600">
                                <span class="ml-2 text-sm">Actief</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" name="status" value="inactive" 
                                       class="h-4 w-4 text-blue-600">
                                <span class="ml-2 text-sm">Inactief</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-between">
                    <div>
                        <button type="button" 
                                class="px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50">
                            <i class="fa fa-trash-alt mr-2"></i>Verwijderen
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Annuleren
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Opslaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('edit-employee-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Medewerker bijgewerkt!');
            // In een echte app zou je hier een fetch/POST doen
        });
    </script>
</body>
@endsection