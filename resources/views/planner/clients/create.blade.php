@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Titel + terug -->
    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('planner.clients.index') }}"
           class="mt-1 text-gray-600 hover:text-gray-900"
           title="Terug naar overzicht">
            <i class="fa fa-arrow-left text-xl"></i>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nieuwe cliënt</h1>
            <p class="text-gray-600 mt-1">
                Vul de gegevens in om een cliënt toe te voegen
            </p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('planner.clients.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Naam -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Naam *
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       required>
            </div>

            <!-- BSN -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    BSN *
                </label>
                <input type="text"
                       name="bsn"
                       value="{{ old('bsn') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm"
                       required>
            </div>

            <!-- Telefoon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Telefoon
                </label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm">
            </div>

            <!-- Adres -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Adres
                </label>
                <input type="text"
                       name="address"
                       value="{{ old('address') }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm">
            </div>

            {{-- Zorgmomenten --}}
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">
                    Zorgmomenten (optioneel)
                </h2>
                <p class="text-sm text-gray-600 mb-3">
                    Kies welke zorgmomenten deze cliënt nodig heeft en vul de duur in minuten in.
                </p>

                @php
                    $moments = [
                        'ochtend' => 'Ochtend',
                        'middag_1' => '1e Middag',
                        'middag_2' => '2e Middag',
                        'avond' => 'Avond',
                    ];
                @endphp

                <!-- Select -->
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Selecteer zorgmoment(en)
                </label>

                <select id="zorgMomentsSelect"
                        name="selected_moments[]"
                        multiple
                        class="w-full border border-gray-300 rounded-md p-2 text-sm
                               focus:outline-none focus:ring-1 focus:ring-blue-500
                               focus:border-blue-500">
                    @foreach($moments as $key => $label)
                        <option value="{{ $key }}"
                            @selected(in_array($key, old('selected_moments', [])))>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <!-- Dynamische velden -->
                <div id="zorgMomentFields" class="mt-4 space-y-3">
                    @foreach($moments as $key => $label)
                        <div id="field-{{ $key }}"
                             class="{{ in_array($key, old('selected_moments', [])) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $label }} — zorgduur (minuten)
                            </label>
                            <input type="number"
                                   min="1"
                                   name="zorg[{{ $key }}]"
                                   value="{{ old("zorg.$key") }}"
                                   placeholder="Bijv. 30"
                                   class="w-full md:w-64 border border-gray-300 rounded-md p-2 text-sm
                                          focus:outline-none focus:ring-1 focus:ring-blue-500
                                          focus:border-blue-500">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Acties -->
            <div class="flex justify-end gap-3 pt-6">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('zorgMomentsSelect');
    const keys = ['ochtend', 'middag_1', 'middag_2', 'avond'];

    function updateFields() {
        const selected = Array.from(select.selectedOptions).map(o => o.value);

        keys.forEach(key => {
            const field = document.getElementById('field-' + key);
            const input = field.querySelector('input');

            if (selected.includes(key)) {
                field.classList.remove('hidden');
            } else {
                input.value = '';
                field.classList.add('hidden');
            }
        });
    }

    select.addEventListener('change', updateFields);
    updateFields();
});
</script>
@endsection