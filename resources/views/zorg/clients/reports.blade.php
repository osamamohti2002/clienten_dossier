@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('zorg.clients.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fa fa-arrow-left mr-2"></i>Terug naar cliënten
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Rapportage</h1>
        <p class="text-gray-600 mt-1">Cliënt: <span class="font-semibold">{{ $client->name }}</span></p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">
            <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('zorg.clients.reports.store', $client->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nieuwe rapportage *</label>
                <textarea name="report"
                          rows="5"
                          class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('report') border-red-500 @enderror"
                          placeholder="Schrijf hier je rapportage...">{{ old('report') }}</textarea>

                @error('report')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fa fa-save mr-2"></i>Opslaan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection