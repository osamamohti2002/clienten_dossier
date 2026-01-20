@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Nieuwe meting – {{ $client->name }}
        </h1>
        <p class="text-gray-600 mt-1">
            Kies een type meting en vul de waarden in
        </p>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200 text-red-800">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST"
              action="{{ route('zorg.measurements.store', $client) }}"
              class="space-y-6">
            @csrf

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Type meting *
                </label>
                <select id="measurementType"
                        name="type"
                        required
                        class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    <option value="">— Kies type —</option>
                    <option value="weight">Gewicht</option>
                    <option value="blood_pressure">Bloeddruk</option>
                    <option value="temperature">Temperatuur</option>
                    <option value="blood_sugar">Bloedsuiker</option>
                </select>
            </div>

            {{-- Gewicht --}}
            <div id="fields-weight" class="hidden space-y-3">
                <input type="number" step="0.01" name="weight_kg"
                       placeholder="Gewicht (kg)"
                       class="w-full border rounded-md p-2">
                <input type="number" name="height_cm"
                       placeholder="Lengte (cm)"
                       class="w-full border rounded-md p-2">
            </div>

            {{-- Bloeddruk --}}
            <div id="fields-blood_pressure" class="hidden space-y-3">
                <input type="number" name="systolic"
                       placeholder="Bovendruk"
                       class="w-full border rounded-md p-2">
                <input type="number" name="diastolic"
                       placeholder="Onderdruk"
                       class="w-full border rounded-md p-2">
                <input type="number" name="heart_rate"
                       placeholder="Hartslag"
                       class="w-full border rounded-md p-2">
            </div>

            {{-- Temperatuur --}}
            <div id="fields-temperature" class="hidden">
                <input type="number" step="0.1" name="temperature_c"
                       placeholder="Temperatuur (°C)"
                       class="w-full border rounded-md p-2">
            </div>

            {{-- Bloedsuiker --}}
            <div id="fields-blood_sugar" class="hidden">
                <input type="number" step="0.1" name="blood_sugar"
                       placeholder="Bloedsuiker"
                       class="w-full border rounded-md p-2">
            </div>

            {{-- Acties --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('zorg.measurements.index', $client) }}"
                   class="px-4 py-2 border rounded-md text-gray-700">
                    Annuleren
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('measurementType');
        const types = ['weight', 'blood_pressure', 'temperature', 'blood_sugar'];

        function update() {
            types.forEach(t =>
                document.getElementById('fields-' + t).classList.add('hidden')
            );
            if (select.value) {
                document.getElementById('fields-' + select.value).classList.remove('hidden');
            }
        }

        select.addEventListener('change', update);
        update();
    });
</script>
@endsection