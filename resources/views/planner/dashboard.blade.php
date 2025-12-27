@extends('layouts.app')

@section('content')
<div class="bg-gray-50 text-gray-800">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        {{-- Gebruik later een echte asset() --}}
                        <img class="h-10 w-auto mr-3 object-contain"
                            src="{{ asset('media/logo/ZorgSysteem_logo.png') }}"
                            alt="ZorgSysteem logo">
                        <span class="text-xl font-bold text-gray-900">ZorgSysteem</span>
                    </div>
                </div>

                <!-- Middle: nav buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('planner.dashboard') }}"
                       class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Routes
                    </a>

                    {{-- Later koppelen aan planner.clients.index --}}
                    <a href="{{ route('planner.clients.index') }}"
                       class="px-4 py-2 rounded-md border border-blue-600 text-blue-600 text-sm font-medium hover:bg-blue-50">
                        Cliënten
                    </a>
                </div>

                <!-- Right: Profile & Actions -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="flex items-center text-sm rounded-full">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fa fa-user text-blue-600"></i>
                            </div>
                            <span class="ml-2 hidden md:block">
                                {{ auth()->user()->name ?? 'Planner' }}
                            </span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <i class="fa fa-sign-out mr-2"></i>Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Dashboard Title -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Planner Dashboard</h1>
                    <p class="text-gray-600 mt-2">Beheer planning en routes voor zorgpersoneel</p>
                </div>

                <!-- Stats (placeholder, later dynamisch) -->
                <div class="hidden md:grid grid-cols-2 gap-4">
                    <div class="bg-white shadow rounded-lg px-4 py-3 text-center">
                        <div class="text-xs text-gray-500">Routes vandaag</div>
                        <div class="text-2xl font-bold text-gray-900">0</div>
                    </div>
                    <div class="bg-white shadow rounded-lg px-4 py-3 text-center">
                        <div class="text-xs text-gray-500">Cliënten totaal</div>
                        <div class="text-2xl font-bold text-gray-900">0</div>
                    </div>
                </div>
            </div>

            <!-- Routes Overview -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md mb-8">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Routes Overzicht</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Direct overzicht van aangemaakte routes</p>
                    </div>
                    <button id="new-route-btn"
                            type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                        <i class="fa fa-plus-circle mr-2"></i>Nieuwe route
                    </button>
                </div>

                <!-- Date Filter -->
                <div class="px-4 py-3 bg-gray-50 border-t border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <label for="route-date-filter" class="block text-sm font-medium text-gray-700">Filter op datum</label>
                            <input type="date" id="route-date-filter"
                                   class="mt-1 block w-full md:w-auto border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fa fa-history mr-2"></i>Oude routes bekijken
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Routes List (placeholder) -->
                <div class="divide-y divide-gray-200">
                    <div class="px-4 py-6 sm:px-6 text-center text-gray-500">
                        Nog geen routes. Maak een nieuwe route aan om te starten.
                    </div>
                </div>
            </div>

            <!-- New Route Form (Hidden by default) -->
            <div id="new-route-form" class="hidden bg-white shadow overflow-hidden sm:rounded-md mb-8">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Nieuwe route aanmaken</h3>
                    <p class="mt-1 text-sm text-gray-500">Vul de gegevens in om een nieuwe route te maken</p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Zorgmedewerker *</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm">
                                <option value="">Selecteer zorgmedewerker</option>
                                <option value="1">Sanne Visser</option>
                                <option value="2">Thomas Jansen</option>
                                <option value="3">Emma de Bruin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Datum *</label>
                            <input type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Shift *</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm">
                                <option value="ochtend">Ochtend</option>
                                <option value="avond">Avond</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Starttijd *</label>
                            <input type="time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm" value="08:30">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Cliënten selecteren *</label>
                            <select multiple class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm h-32">
                                <option value="1">Jan Jansen (Kerkstraat 123, Amsterdam)</option>
                                <option value="2">Maria de Vries (Dorpsweg 45, Utrecht)</option>
                                <option value="3">Peter Bakker (Beukenlaan 67, Rotterdam)</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Houd Ctrl ingedrukt om meerdere cliënten te selecteren</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancel-new-route"
                                class="py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Annuleren
                        </button>
                        <button type="button"
                                class="py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Route aanmaken
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newRouteForm = document.getElementById('new-route-form');
    const newRouteBtn = document.getElementById('new-route-btn');
    const cancelNewRouteBtn = document.getElementById('cancel-new-route');

    if (newRouteBtn && newRouteForm) {
        newRouteBtn.addEventListener('click', function() {
            newRouteForm.classList.toggle('hidden');
        });
    }

    if (cancelNewRouteBtn && newRouteForm) {
        cancelNewRouteBtn.addEventListener('click', function() {
            newRouteForm.classList.add('hidden');
        });
    }
});
</script>
@endsection