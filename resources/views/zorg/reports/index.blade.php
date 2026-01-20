@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">

    {{-- Titel --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Rapportages – {{ $client->name }}
        </h1>
        <p class="text-gray-600 mt-1">
            Overzicht van alle rapportages voor deze cliënt
        </p>
    </div>

    {{-- Succesmelding --}}
    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- NIEUWE RAPPORTAGE --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">
            Nieuwe rapportage
        </h2>

        <form method="POST" action="{{ route('zorg.reports.store', $client) }}">
            @csrf

            <textarea name="report"
                      rows="4"
                      class="w-full border border-gray-300 rounded-md p-3 text-sm
                             focus:outline-none focus:ring-1 focus:ring-blue-500
                             focus:border-blue-500"
                      placeholder="Schrijf hier je rapportage..."
                      required>{{ old('report') }}</textarea>

            @error('report')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            <div class="mt-4 flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Opslaan
                </button>
            </div>
        </form>
    </div>

    {{-- BESTAANDE RAPPORTAGES --}}
    <div class="space-y-4">
        @forelse($reports as $report)
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">
                            {{ $report->user->name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $report->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>

                    {{-- Alleen eigen rapportages: acties --}}
                    @if($report->user_id === auth()->id())
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('zorg.reports.edit', $report) }}"
                               class="text-blue-600 hover:text-blue-900">
                                Bewerken
                            </a>

                            <form method="POST"
                                  action="{{ route('zorg.reports.destroy', $report) }}"
                                  onsubmit="return confirm('Rapportage verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900">
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <p class="mt-3 text-gray-700 whitespace-pre-line">
                    {{ $report->report }}
                </p>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Nog geen rapportages voor deze cliënt.
            </div>
        @endforelse
    </div>

    {{-- Terug --}}
    <div class="mt-8">
        <a href="{{ route('zorg.clients.index') }}"
           class="text-gray-600 hover:text-gray-900">
            ← Terug naar cliënten
        </a>
    </div>

</div>
@endsection