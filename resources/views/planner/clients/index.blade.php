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
                        <img class="h-10 w-auto mr-3 object-contain"
                             src="{{ asset('media/logo/ZorgSysteem_logo.png') }}"
                             alt="ZorgSysteem logo">
                        <span class="text-xl font-bold text-gray-900">ZorgSysteem</span>
                    </div>
                </div>

                <!-- Middle: nav buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('planner.dashboard') }}"
                       class="px-4 py-2 rounded-md border border-blue-600 text-blue-600 text-sm font-medium hover:bg-blue-50">
                        Routes
                    </a>

                    <a href="{{ route('planner.clients.index') }}"
                       class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Cliënten
                    </a>
                </div>

                <!-- Right: Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm rounded-full">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fa fa-user text-blue-600"></i>
                        </div>
                        <span class="ml-2 hidden md:block">
                            {{ auth()->user()->name ?? 'Planner' }}
                        </span>
                    </div>

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

    <!-- Page content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Title + add button -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Cliënten</h1>
                    <p class="text-gray-600 mt-1">Beheer cliënten</p>
                </div>

                <!-- Nog geen create route: tijdelijk # -->
                <a href="{{ route('planner.clients.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    <i class="fa fa-plus mr-2"></i>Nieuwe cliënt
                </a>
            </div>

            <!-- Search -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('planner.clients.index') }}" class="max-w-md">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zoeken</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Zoek op naam..."
                           class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                </form>
            </div>

            <!-- Clients table (placeholder) -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adres</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefoon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($clients as $client)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $client->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $client->address ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $client->phone ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="#"
                                           class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fa fa-edit mr-1"></i>Bewerken
                                        </a>
                        
                                        <button type="button"
                                                class="text-red-600 hover:text-red-900"
                                                onclick="alert('Delete komt straks');">
                                            <i class="fa fa-trash mr-1"></i>Verwijderen
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Nog geen cliënten. Klik op “Nieuwe cliënt” om te starten.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection