@extends('layouts.app')
@extends('layouts.navbars.adminNav')
@section('content')
        <div class="fade-in">
            <div class="px-4 py-6 sm:px-0">
                <!-- Dashboard Title -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 mt-2">Technisch beheer van medewerkers en autorisaties</p>
                </div>
                
                <!-- Stats Cards (ONLY NUMBERS per requirements) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-sm font-medium text-gray-500 truncate">Totaal cliënten</dt>
                            <dd class="mt-1 text-5xl font-semibold text-gray-900">142</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-sm font-medium text-gray-500 truncate">Totaal medewerkers</dt>
                            <dd class="mt-1 text-5xl font-semibold text-gray-900">28</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-sm font-medium text-gray-500 truncate">Totaal routes vandaag</dt>
                            <dd class="mt-1 text-5xl font-semibold text-gray-900">63</dd>
                        </div>
                    </div>
                </div>
                
                <!-- Personnel Management -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Personeelsbeheer</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Beheer alle medewerkers</p>
                        </div>
                        <button id="add-employee-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                            <i class="fa fa-user-plus mr-2"></i>Voeg medewerker toe
                        </button>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="px-4 py-3 bg-gray-50 border-t border-b border-gray-200">
                        <div class="max-w-xs">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa fa-search text-gray-400"></i>
                                </div>
                                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Zoek medewerker...">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Personnel Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fa fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Lisa van Dijk</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">l.vandijk@zorgsysteem.nl</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fa fa-edit mr-1"></i>Bewerken
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa fa-trash-alt mr-1"></i>Verwijderen
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="fa fa-calendar text-green-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Mark de Jong</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Planner</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">m.dejong@zorgsysteem.nl</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fa fa-edit mr-1"></i>Bewerken
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa fa-trash-alt mr-1"></i>Verwijderen
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-yellow-100 flex items-center justify-center">
                                                <i class="fa fa-user-md text-yellow-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sanne Visser</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Zorgpersoneel</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">s.visser@zorgsysteem.nl</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fa fa-edit mr-1"></i>Bewerken
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa fa-trash-alt mr-1"></i>Verwijderen
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Add Employee Form (Hidden by default) -->
                    <div id="add-employee-form" class="hidden px-4 py-5 sm:p-6 border-t border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Nieuwe medewerker toevoegen</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="employee-name" class="block text-sm font-medium text-gray-700">Naam</label>
                                <input type="text" id="employee-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="employee-email" class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input type="email" id="employee-email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="employee-password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                                <input type="password" id="employee-password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="employee-role" class="block text-sm font-medium text-gray-700">Rol</label>
                                <select id="employee-role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="zorgpersoneel">Zorgpersoneel</option>
                                    <option value="planner">Planner</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancel-add-employee" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Annuleren</button>
                            <button type="button" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Medewerker toevoegen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addEmployeeForm = document.getElementById('add-employee-form');
            
            // Add Employee Form Toggle
            const addEmployeeBtn = document.getElementById('add-employee-btn');
            if (addEmployeeBtn) {
                addEmployeeBtn.addEventListener('click', function() {
                    addEmployeeForm.classList.toggle('hidden');
                });
            }
            
            // Cancel Add Employee
            const cancelAddEmployeeBtn = document.getElementById('cancel-add-employee');
            if (cancelAddEmployeeBtn) {
                cancelAddEmployeeBtn.addEventListener('click', function() {
                    addEmployeeForm.classList.add('hidden');
                });
            }
        });
    </script>
@endsection