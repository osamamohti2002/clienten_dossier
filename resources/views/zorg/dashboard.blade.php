@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Zorgpersoneel Dashboard</h1>
        <p class="text-gray-600 mt-2">Overzicht van jouw planning en cliënten</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Planning vandaag</h2>
        <p class="text-gray-600">
            Je bent vrij vandaag of er zijn geen diensten gepland.
        </p>
    </div>

</div>
@endsection