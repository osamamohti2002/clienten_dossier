@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Dashboard Title + Stats -->
    <div class="mb-8 flex items-start justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Planner Dashboard</h1>
            <p class="text-gray-600 mt-2">Beheer planning en routes voor zorgpersoneel</p>
        </div>

        <!-- Stats -->
        <div class="hidden md:grid grid-cols-2 gap-4">
            <div class="bg-white shadow rounded-lg px-4 py-3 text-center">
                <div class="text-xs text-gray-500">Routes vandaag</div>
                <div class="text-2xl font-bold text-gray-900">
                    {{ $routesTodayCount ?? 0 }}
                </div>
            </div>
            <div class="bg-white shadow rounded-lg px-4 py-3 text-center">
                <div class="text-xs text-gray-500">Cliënten totaal</div>
                <div class="text-2xl font-bold text-gray-900">
                    {{ $clientsCount ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    @php
        // helper voor shift styling (zoals admin badges/kleuren)
        $shiftBadge = function ($shift) {
            return match($shift) {
                'ochtend' => ['label' => 'Ochtend', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-sun-o', 'circle' => 'bg-yellow-100', 'circleText' => 'text-yellow-600'],
                'avond'   => ['label' => 'Avond',   'bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'icon' => 'fa-moon-o', 'circle' => 'bg-indigo-100', 'circleText' => 'text-indigo-600'],
                default   => ['label' => ucfirst($shift ?? 'Onbekend'), 'bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-clock-o', 'circle' => 'bg-gray-100', 'circleText' => 'text-gray-600'],
            };
        };
    @endphp

    <!-- Routes Overview -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md mb-8">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Routes Overzicht</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Direct overzicht van aangemaakte routes</p>
            </div>

            <a href="{{ route('planner.routes.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                <i class="fa fa-plus-circle mr-2"></i>Nieuwe route
            </a>
        </div>

        <!-- Date Filter (placeholder UI) -->
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

        <!-- Routes List -->
        <div class="divide-y divide-gray-200">
            @if(isset($routes) && $routes->count())
                @foreach($routes as $route)
                    @php $s = $shiftBadge($route->shift); @endphp

                    <div class="border-b border-gray-200">
                        <!-- Route header (clickable for dropdown) -->
                        <button type="button"
                                onclick="toggleRoute({{ $route->id }})"
                                class="w-full text-left px-4 py-4 sm:px-6 hover:bg-gray-50 flex items-start justify-between gap-4">

                            <div class="flex items-start gap-3">
                                <!-- Rond icoon zoals admin -->
                                <div class="h-10 w-10 flex-shrink-0 rounded-full {{ $s['circle'] }} flex items-center justify-center">
                                    <i class="fa {{ $s['icon'] }} {{ $s['circleText'] }}"></i>
                                </div>

                                <div>
                                    <!-- Titel -->
                                    <div class="font-semibold text-gray-900">
                                        Route: {{ $route->zorgpersoneel->user->name ?? 'Onbekend' }}
                                    </div>

                                    <!-- Badges -->
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        <!-- Shift -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['bg'] }} {{ $s['text'] }}">
                                            <i class="fa {{ $s['icon'] }} mr-1"></i>{{ $s['label'] }}
                                        </span>

                                        <!-- Datum -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fa fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($route->datum)->format('d/m/Y') }}
                                        </span>

                                        <!-- Tijd -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fa fa-clock-o mr-1"></i>
                                            {{ \Carbon\Carbon::parse($route->starttijd)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($route->eindtijd)->format('H:i') }}
                                        </span>

                                        <!-- Cliënten count -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fa fa-users mr-1"></i>
                                            {{ $route->visits?->count() ?? 0 }} cliënten
                                        </span>
                                    </div>

                                    <!-- (optioneel) Aangemaakt door -->
                                    @if(isset($route->planner) && $route->planner)
                                        <div class="mt-2 text-sm text-gray-500">
                                            <i class="fa fa-user mr-1"></i>Aangemaakt door: {{ $route->planner->user->name ?? 'Onbekend' }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-gray-400 mt-1">
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </button>

                        <!-- Dropdown content -->
                        <div id="route-details-{{ $route->id }}" class="hidden bg-gray-50 px-6 py-4">
                            @if($route->visits && $route->visits->count())
                                <ul class="space-y-2">
                                    @foreach($route->visits as $visit)
                                        <li class="flex justify-between text-sm text-gray-700">
                                            @php
                                                $duurMin = $visit->zorgMoment?->duration_minutes;

                                                // fallback: bereken uit start/end als duration ontbreekt
                                                if (!$duurMin && $visit->start_time && $visit->end_time) {
                                                    $duurMin = \Carbon\Carbon::parse($visit->start_time)
                                                        ->diffInMinutes(\Carbon\Carbon::parse($visit->end_time));
                                                }

                                                $momentLabel = match($visit->zorgMoment?->moment) {
                                                    'ochtend'  => 'Ochtend',
                                                    'middag_1' => 'Eind ochtend',
                                                    'middag_2' => 'Eind middag',
                                                    'avond'    => 'Avond',
                                                    default    => $visit->zorgMoment?->moment ?? 'Onbekend',
                                                };
                                            @endphp

                                            <li class="flex justify-between text-sm text-gray-700">
                                                <span>
                                                    {{ $visit->client->name ?? $visit->client->naam ?? 'Onbekend' }}
                                                    <span class="text-gray-400">({{ $momentLabel }})</span>
                                                </span>

                                                <span class="text-gray-500">
                                                    {{ $visit->start_time ? \Carbon\Carbon::parse($visit->start_time)->format('H:i') : '--:--' }}
                                                    -
                                                    {{ $visit->end_time ? \Carbon\Carbon::parse($visit->end_time)->format('H:i') : '--:--' }}
                                                    • duur: <span class="font-medium text-gray-700">{{ $duurMin ?? 0 }} min</span>
                                                </span>
                                            </li>

                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Geen cliënten in deze route.</p>
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
        if (!el) return;
        el.classList.toggle('hidden');
    }
</script>
@endsection