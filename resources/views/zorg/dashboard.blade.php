@extends('layouts.app')

@section('content')

@php
    // Shift styling helper (same style as planner dashboard)
    $shiftBadge = function ($shift) {
        return match($shift) {
            'ochtend' => [
                'label' => 'Ochtend',
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-800',
                'icon' => 'fa-sun-o',
            ],
            'avond' => [
                'label' => 'Avond',
                'bg' => 'bg-indigo-100',
                'text' => 'text-indigo-800',
                'icon' => 'fa-moon-o',
            ],
            default => [
                'label' => ucfirst($shift ?? 'Onbekend'),
                'bg' => 'bg-gray-100',
                'text' => 'text-gray-800',
                'icon' => 'fa-clock-o',
            ],
        };
    };
@endphp

<div class="px-4 py-6 sm:px-0">

    <!-- Titel -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Zorgpersoneel Dashboard</h1>
        <p class="text-gray-600 mt-2">Overzicht van jouw planning en cliënten</p>
    </div>

    <!-- Planning kaart -->
    <div class="bg-white shadow rounded-lg p-6">

        @php
            $shift = $todayRoute?->shift;
            $s = $shift ? $shiftBadge($shift) : null;
        @endphp

        <!-- Planning titel -->
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-3">
            @if ($s)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['bg'] }} {{ $s['text'] }}">
                    <i class="fa {{ $s['icon'] }} mr-1"></i>
                    {{ $s['label'] }}
                </span>
            @endif

            <span>Planning vandaag – {{ $today }}</span>
        </h2>

        @if ($todayRoute)

            <!-- Timeline -->
            <div class="space-y-6">

                @foreach ($visits as $visit)

                    <div class="relative pl-8">

                        <!-- verticale lijn -->
                        <span class="absolute left-3 top-0 h-full w-px bg-gray-200"></span>

                        <!-- bolletje -->
                        <span class="absolute left-1.5 top-1.5 h-3 w-3 rounded-full bg-blue-500"></span>

                        <!-- kaart -->
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-start gap-4">

                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">
                                        {{ $visit->client->name ?? $visit->client->naam ?? 'Onbekend' }}
                                    </h4>

                                    <div class="mt-2 text-sm text-gray-600">
                                        <i class="fa fa-clock-o mr-1"></i>
                                        {{ $visit->start_time ?? '--:--' }} – {{ $visit->end_time ?? '--:--' }}
                                    </div>

                                    <div class="mt-1 text-sm text-gray-500">
                                        <i class="fa fa-map-marker mr-1"></i>
                                        {{ $visit->client->address ?? 'Adres onbekend' }}
                                    </div>
                                </div>

                                <!-- Acties -->
                                <div class="flex space-x-2">
                                    <a href="#"
                                       class="inline-flex items-center px-3 py-1.5
                                              border border-blue-300 text-sm font-medium
                                              rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                                        <i class="fa fa-folder mr-1.5"></i>
                                        Dossier
                                    </a>

                                    <a href="#"
                                       class="inline-flex items-center px-3 py-1.5
                                              border border-green-300 text-sm font-medium
                                              rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                                        <i class="fa fa-heartbeat mr-1.5"></i>
                                        Rapportage
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <!-- Geen planning -->
            <div class="text-center py-12 text-gray-500">
                <i class="fa fa-calendar-o text-4xl mb-4"></i>
                <p class="text-lg font-medium">Je bent vandaag vrij</p>
                <p class="text-sm mt-1">Er zijn geen diensten ingepland.</p>
            </div>

        @endif

    </div>

</div>
@endsection
