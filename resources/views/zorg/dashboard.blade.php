@extends('layouts.app')

@section('content')
<p class="text-sm text-gray-500">Dashboard loaded</p>

<div class="px-4 py-6 sm:px-0">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Zorgpersoneel Dashboard</h1>
        <p class="text-gray-600 mt-2">Overzicht van jouw planning en cliënten</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            Planning vandaag – {{ $today }}
        </h2>

      @if ($todayRoute)

        <ul class="mt-4 space-y-2">
            @foreach ($visits as $visit)
                <li class="border rounded p-3">
                    <strong>{{ $visit->client->name }}</strong><br>
                    <span class="text-sm text-gray-600">
                        {{ $visit->client->address }}
                    </span><br>
                    <span class="text-sm text-gray-500">
                        {{ $visit->start_time }} – {{ $visit->end_time }}
                    </span>
                </li>
            @endforeach
        </ul>

      @else
        <p class="text-gray-600">
            Je bent vrij vandaag of er zijn geen diensten gepland.
        </p>

@endif


    </div>

</div>
@endsection