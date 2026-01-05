@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Nieuwe cliënt</h1>
        <p class="text-gray-600 mt-1">Vul de gegevens in om een cliënt toe te voegen</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('planner.clients.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Naam -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Naam *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       placeholder="Bijv. Jan Jansen" required>
            </div>

            <!-- BSN -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">BSN *</label>
                <input type="text" name="bsn" value="{{ old('bsn') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       placeholder="Bijv. 123456789" required>
            </div>

            <!-- Telefoon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefoon</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       placeholder="Bijv. 06-12345678">
            </div>

            <!-- Adres -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       placeholder="Bijv. Kerkstraat 1, Amsterdam">
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('planner.clients.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuleren
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection