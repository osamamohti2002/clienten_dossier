@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6 flex items-start gap-4">
        <!-- Terug pijl -->
        <a href="{{ route('planner.clients.index') }}"
           class="mt-1 text-gray-600 hover:text-gray-900"
           title="Terug naar overzicht">
            <i class="fa fa-arrow-left text-xl"></i>
        </a>

        <!-- Titel -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cliënt bewerken</h1>
            <p class="text-gray-600 mt-1">
                Wijzig de gegevens van <span class="font-semibold">{{ $client->name }}</span>
            </p>
        </div>
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
                       placeholder="Bijv. Jan Jansen" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Geslacht -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Geslacht</label>
                <select name="gender"
                        class="w-full border border-gray-300 rounded-md p-2 text-sm @error('gender') border-red-500 @enderror">
                    @php
                        $currentGender = old('gender', $client->gender ?? 'unknown');
                    @endphp
                    <option value="unknown" @selected($currentGender === 'unknown')>Onbekend</option>
                    <option value="male" @selected($currentGender === 'male')>Man</option>
                    <option value="female" @selected($currentGender === 'female')>Vrouw</option>
                </select>
                @error('gender')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- BSN -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">BSN *</label>
                <input type="text" name="bsn" value="{{ old('bsn', $client->bsn) }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm @error('bsn') border-red-500 @enderror"
                       placeholder="Bijv. 123456789" required>
                @error('bsn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telefoon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefoon</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm @error('phone') border-red-500 @enderror"
                       placeholder="Bijv. 06-12345678">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adres -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                <input type="text" name="address" value="{{ old('address', $client->address) }}"
                       class="w-full border border-gray-300 rounded-md p-2 text-sm @error('address') border-red-500 @enderror"
                       placeholder="Bijv. Kerkstraat 1, Amsterdam">
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Zorgmomenten --}}
            <div class="pt-2">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Zorgmomenten</h2>
                <p class="text-sm text-gray-600 mb-3">
                    Kies de momenten die deze cliënt nodig heeft en vul de duur (in minuten) in.
                </p>

                @php
                    $moments = [
                        'ochtend' => 'Ochtend',
                        'middag_1' => '1e Middag',
                        'middag_2' => '2e Middag',
                        'avond' => 'Avond',
                    ];

                    // geselecteerde waarden (old eerst, anders uit database)
                    $oldZorg = old('zorg');
                @endphp

                <label class="block text-sm font-medium text-gray-700 mb-1">Selecteer zorgmoment(en)</label>

                <select id="zorgMomentsSelect"
                        multiple
                        class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($moments as $key => $label)
                        @php
                            $selected = false;

                            if (is_array($oldZorg)) {
                                $selected = !empty($oldZorg[$key] ?? null);
                            } else {
                                $selected = isset($zorgMomenten[$key]);
                            }
                        @endphp

                        <option value="{{ $key }}" @selected($selected)>{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Dynamische velden -->
                <div id="zorgMomentFields" class="mt-4 space-y-3">
                    @foreach($moments as $key => $label)
                        @php
                            // waarde tonen: old('zorg[key]') of uit db
                            $value = old("zorg.$key");
                            if ($value === null && isset($zorgMomenten[$key])) {
                                $value = $zorgMomenten[$key]->duration_minutes;
                            }

                            $visible = !empty($value);
                        @endphp

                        <div id="field-{{ $key }}" class="{{ $visible ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $label }} — zorgduur (minuten)
                            </label>

                            <input type="number"
                                   min="1"
                                   name="zorg[{{ $key }}]"
                                   value="{{ $value }}"
                                   placeholder="Bijv. 30"
                                   class="w-full md:w-64 border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const select = document.getElementById('zorgMomentsSelect');
                    const allMomentKeys = ['ochtend', 'middag_1', 'middag_2', 'avond'];

                    function updateFields() {
                        const selected = Array.from(select.selectedOptions).map(o => o.value);

                        allMomentKeys.forEach(key => {
                            const wrapper = document.getElementById('field-' + key);
                            const input = wrapper ? wrapper.querySelector('input') : null;
                            if (!wrapper) return;

                            if (selected.includes(key)) {
                                wrapper.classList.remove('hidden');
                            } else {
                                if (input) input.value = '';
                                wrapper.classList.add('hidden');
                            }
                        });
                    }

                    select.addEventListener('change', updateFields);
                    updateFields(); // init
                });
            </script>

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
@endsection