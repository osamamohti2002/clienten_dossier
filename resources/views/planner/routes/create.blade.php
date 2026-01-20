@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">Planning aanmaken (Model B)</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-50 text-red-800">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('planner.routes.store') }}" class="space-y-6" id="planningForm">
        @csrf

        {{-- Zorgpersoneel --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Zorgpersoneel</label>
            <select name="zorgpersoneel_id" class="w-full border rounded p-2" required>
                <option value="">Selecteer...</option>
                @foreach($zorgpersoneel as $zp)
                    <option value="{{ $zp->id }}" {{ old('zorgpersoneel_id') == $zp->id ? 'selected' : '' }}>
                        {{ $zp->user->name ?? 'Onbekend' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Datum --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Datum</label>
            <input type="date" name="datum" value="{{ old('datum') }}" class="w-full border rounded p-2" required>
        </div>

        {{-- Shift --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
            <select name="shift" id="shiftSelect" class="w-full border rounded p-2" required>
                <option value="ochtend" {{ old('shift', 'ochtend') === 'ochtend' ? 'selected' : '' }}>Ochtend</option>
                <option value="avond" {{ old('shift') === 'avond' ? 'selected' : '' }}>Avond</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">
                Ochtendplanning: ochtend + eind van de ochtend. Avondplanning: middag + avond.
            </p>
        </div>

        {{-- Starttijd --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Starttijd</label>
            <input type="time" name="starttijd" value="{{ old('starttijd') }}" class="w-full border rounded p-2" required>
        </div>

        {{-- Visits selectie --}}
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-3">Kies zorgmomenten (elk aangevinkt moment = 1 bezoek)</h2>

            @php $i = 0; @endphp

            @foreach($clients as $client)
                <div class="border rounded p-4 mb-4">
                    <div class="font-semibold mb-2">
                        {{ $client->naam ?? $client->name ?? ('Client #'.$client->id) }}
                    </div>

                    @if($client->zorgMomenten->isEmpty())
                        <div class="text-sm text-red-600">Geen zorgmomenten gevonden.</div>
                    @else
                        <div class="space-y-2">
                            @foreach($client->zorgMomenten as $moment)
                                @php
                                    // moment naam als "key" voor filtering (lowercase)
                                    $momentKey = mb_strtolower(trim($moment->moment ?? ''));
                                @endphp
                                @php
                                    $isUsed = in_array($moment->id, $usedMomentIds ?? []);
                                @endphp

                                <div
                                    class="visit-row flex items-center gap-3 text-sm"
                                    @if($isUsed) style="opacity: 0.5;" title="Dit zorgmoment is al ingepland op deze datum." @endif
                                    data-moment="{{ strtolower($momentKey) }}"
                                >
                                    <input
                                        type="checkbox"
                                        class="visit-checkbox"
                                        name="visits[{{ $i }}][enabled]"
                                        value="1"
                                        id="visit_{{ $i }}"
                                        {{ $isUsed ? 'disabled' : '' }}
                                    >

                                    <label class="w-64 cursor-pointer" for="visit_{{ $i }}">
                                        {{ $moment->moment }} ({{ $moment->duration_minutes }} min)
                                        @if ($isUsed)
                                            <span class="text-red-600 ml-2">(al ingepland)</span>
                                        @endif
                                    </label>

                                    <input type="hidden" name="visits[{{ $i }}][client_id]" value="{{ $client->id }}">
                                    <input type="hidden" name="visits[{{ $i }}][client_zorg_moment_id]" value="{{ $moment->id }}">

                                    <span class="text-gray-600">Volgorde:</span>

                                    <input
                                        type="number"
                                        class="visit-sequence w-24 border rounded px-2 py-1"
                                        name="visits[{{ $i }}][sequence]"
                                        value=""
                                        min="1"
                                        placeholder="-"
                                        disabled
                                    >
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
            Planning opslaan
        </button>
    </form>
</div>

<script>
(function () {
    const shiftSelect = document.getElementById('shiftSelect');

    // Welke moment-namen horen bij welke shift
    // LET OP: deze strings moeten matchen met jouw DB values in client_zorg_moments.moment
    const allowedByShift = {
        ochtend: ['ochtend', 'middag_1'],
        avond: ['middag_2', 'avond'],
        };


    function normalize(s) {
        return (s || '').toString().trim().toLowerCase();
    }

    function applyShiftFilter() {
        const shift = shiftSelect.value;
        const allowed = new Set((allowedByShift[shift] || []).map(normalize));

        document.querySelectorAll('.visit-row').forEach(row => {
            const moment = normalize(row.dataset.moment);

            const checkbox = row.querySelector('.visit-checkbox');
            const seqInput = row.querySelector('.visit-sequence');

            const show = allowed.has(moment);

            // Als moment niet toegestaan is: verbergen + uncheck + sequence resetten
            if (!show) {
                row.style.display = 'none';
                if (checkbox.checked) {
                    checkbox.checked = false;
                }
                seqInput.value = '';
                seqInput.disabled = true;
            } else {
                row.style.display = 'flex';
            }
        });

        // Na filteren opnieuw sequence nummers zetten
        autoAssignSequences();
    }

    function autoAssignSequences() {
        let n = 1;
        document.querySelectorAll('.visit-row').forEach(row => {
            if (row.style.display === 'none') return;

            const checkbox = row.querySelector('.visit-checkbox');
            const seqInput = row.querySelector('.visit-sequence');

            if (checkbox.checked) {
                seqInput.disabled = false;
                seqInput.value = n;
                n++;
            } else {
                seqInput.value = '';
                seqInput.disabled = true;
            }
        });
    }

    // Events
    shiftSelect.addEventListener('change', applyShiftFilter);

    document.querySelectorAll('.visit-checkbox').forEach(cb => {
        cb.addEventListener('change', autoAssignSequences);
    });

    // init on load
    applyShiftFilter();
})();
</script>
@endsection
