@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Meting bewerken – {{ $measurement->client->name }}
        </h1>
        <p class="text-gray-600 mt-1">Pas de meting aan en sla op.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200 text-red-800">
            <div class="font-semibold mb-2">Controleer je invoer:</div>
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('zorg.measurements.update', $measurement) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type meting *</label>
                <select id="measurementType"
                        name="type"
                        class="w-full border border-gray-300 rounded-md p-2 text-sm"
                        required>
                    <option value="weight" @selected(old('type', $measurement->type) === 'weight')>Gewicht</option>
                    <option value="blood_pressure" @selected(old('type', $measurement->type) === 'blood_pressure')>Bloeddruk</option>
                    <option value="temperature" @selected(old('type', $measurement->type) === 'temperature')>Temperatuur</option>
                    <option value="blood_sugar" @selected(old('type', $measurement->type) === 'blood_sugar')>Bloedsuiker</option>
                </select>
            </div>

            {{-- Gewicht --}}
            <div id="fields-weight" class="hidden space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gewicht (kg) *</label>
                    <input type="number" step="0.01" min="0" name="weight_kg"
                           value="{{ old('weight_kg', $measurement->weight_kg) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lengte (cm) *</label>
                    <input type="number" min="0" name="height_cm"
                           value="{{ old('height_cm', $measurement->height_cm) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
            </div>

            {{-- Bloeddruk --}}
            <div id="fields-blood_pressure" class="hidden space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bovendruk *</label>
                    <input type="number" min="0" name="systolic"
                           value="{{ old('systolic', $measurement->systolic) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Onderdruk *</label>
                    <input type="number" min="0" name="diastolic"
                           value="{{ old('diastolic', $measurement->diastolic) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hartslag *</label>
                    <input type="number" min="0" name="heart_rate"
                           value="{{ old('heart_rate', $measurement->heart_rate) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
            </div>

            {{-- Temperatuur --}}
            <div id="fields-temperature" class="hidden space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Temperatuur (°C) *</label>
                    <input type="number" step="0.1" min="0" name="temperature_c"
                           value="{{ old('temperature_c', $measurement->temperature_c) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
            </div>

            {{-- Bloedsuiker --}}
            <div id="fields-blood_sugar" class="hidden space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bloedsuiker *</label>
                    <input type="number" step="0.1" min="0" name="blood_sugar"
                           value="{{ old('blood_sugar', $measurement->blood_sugar) }}"
                           class="w-full border border-gray-300 rounded-md p-2 text-sm">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('zorg.measurements.index', $measurement->client_id) }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuleren
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('measurementType');
        const all = ['weight', 'blood_pressure', 'temperature', 'blood_sugar'];

        function hideAll() {
            all.forEach(t => document.getElementById('fields-' + t).classList.add('hidden'));
        }

        function showSelected() {
            hideAll();
            const val = typeSelect.value;
            document.getElementById('fields-' + val).classList.remove('hidden');
        }

        typeSelect.addEventListener('change', showSelected);
        showSelected();
    });
</script>
@endsection