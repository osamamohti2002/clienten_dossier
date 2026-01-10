@extends('layouts.app')

@section('content')
<div class="bg-gray-50 text-gray-800">
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <!-- Title -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Cliënt bewerken</h1>
                <p class="text-gray-600 mt-1">Wijzig de gegevens van {{ $client->name }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('planner.clients.update', $client->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Naam -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Naam *</label>
                        <input type="text" name="name" value="{{ old('name', $client->name) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm @error('name') border-red-500 @enderror"
                               required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- BSN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">BSN *</label>
                        <input type="text" name="bsn" value="{{ old('bsn', $client->bsn) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm @error('bsn') border-red-500 @enderror"
                               required>
                        @error('bsn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Telefoon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telefoon</label>
                        <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Adres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                        <input type="text" name="address" value="{{ old('address', $client->address) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm @error('address') border-red-500 @enderror">
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Zorgmomenten --}}
                    @php
                        $moments = [
                            'ochtend' => 'Ochtend',
                            'middag_1' => '1e Middag',
                            'middag_2' => '2e Middag',
                            'avond' => 'Avond',
                        ];

                        // geselecteerde moments uit DB (keys)
                        $selectedFromDb = $zorgMomenten->keys()->toArray();
                        $selected = old('selected_moments', $selectedFromDb);
                    @endphp

                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Zorgmomenten (optioneel)</h2>
                        <p class="text-sm text-gray-600 mb-3">
                            Kies welke momenten nodig zijn en vul per moment de zorgduur in minuten in.
                        </p>

                        <label class="block text-sm font-medium text-gray-700 mb-1">Selecteer zorgmoment(en)</label>
                        <select id="zorgMomentsSelect"
                                name="selected_moments[]"
                                multiple
                                class="w-full border border-gray-300 rounded-md p-2 text-sm
                                       focus:outline-none focus:ring-1 focus:ring-blue-500
                                       focus:border-blue-500">
                            @foreach($moments as $key => $label)
                                <option value="{{ $key }}" @selected(in_array($key, $selected))>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Dynamische velden -->
                        <div id="zorgMomentFields" class="mt-4 space-y-3">
                            @foreach($moments as $key => $label)
                                <div id="field-{{ $key }}"
                                     class="{{ in_array($key, $selected) ? '' : 'hidden' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $label }} — zorgduur (minuten)
                                    </label>

                                    <input type="number"
                                           min="1"
                                           name="zorg[{{ $key }}]"
                                           value="{{ old("zorg.$key", optional($zorgMomenten->get($key))->duration_minutes) }}"
                                           placeholder="Bijv. 30"
                                           class="w-full md:w-64 border border-gray-300 rounded-md p-2 text-sm
                                                  focus:outline-none focus:ring-1 focus:ring-blue-500
                                                  focus:border-blue-500">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('planner.clients.index') }}"
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
    </main>
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