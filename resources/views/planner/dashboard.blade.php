@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

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

            {{-- ✅ Link to separate create page --}}
            <a href="{{ route('planner.routes.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                <i class="fa fa-plus-circle mr-2"></i>Nieuwe route
            </a>
        </div>

        <!-- Date Filter (still placeholder UI) -->
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

        <!-- Routes List (dynamic) -->
        <div class="divide-y divide-gray-200">
            @if(isset($routes) && $routes->count())
                @foreach($routes as $route)
            <div class="border-b border-gray-200">

                <!-- Route header (clickable) -->
                <button
                    type="button"
                    onclick="toggleRoute({{ $route->id }})"
                    class="w-full text-left px-4 py-4 sm:px-6 flex justify-between items-center hover:bg-gray-50"
                >
                    <div>
                        <div class="font-semibold text-gray-900">
                            {{ $route->zorgpersoneel->user->name ?? 'Onbekend' }}
                            — {{ ucfirst($route->shift) }}
                        </div>

                        <div class="text-sm text-gray-600">
                            {{ $route->datum }} | {{ $route->starttijd }} - {{ $route->eindtijd }}
                        </div>

                        <div class="text-sm text-gray-500">
                            Clients: {{ $route->visits?->count() ?? 0 }}
                        </div>
                    </div>

                    <div class="text-gray-400">
                        ⬇️
                    </div>
                </button>

                <!-- Dropdown content (hidden by default) -->
                <div
                    id="route-details-{{ $route->id }}"
                    class="hidden bg-gray-50 px-6 py-4"
                >
                    @if($route->visits && $route->visits->count())
                        <ul class="space-y-2">
                            @foreach($route->visits as $visit)
                                <li class="flex justify-between text-sm text-gray-700">
                                    <span>{{ $visit->client->name }}</span>
                                    <span class="text-gray-400">duration: not filled</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No clients in this route.</p>
                    @endif
                </div>

            </div>
        @endforeach
            @else
                <div class="px-4 py-6 sm:px-6 text-center text-gray-500">
                    Nog geen routes. Maak een nieuwe route aan om te starten.
                </div>
            @endif
        </div>
    </div>

</div>

<script>
    function toggleRoute(routeId) {
        const el = document.getElementById('route-details-' + routeId);
        el.classList.toggle('hidden');
    }
</script>

@endsection
