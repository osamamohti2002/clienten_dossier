@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">

    {{-- Titel --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Metingen – {{ $client->name }}
        </h1>
        <p class="text-gray-600 mt-1">
            Overzicht van alle geregistreerde metingen
        </p>
    </div>

    {{-- Succesmelding --}}
    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Acties --}}
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('zorg.clients.index') }}"
           class="text-gray-600 hover:text-gray-900">
            ← Terug naar cliënten
        </a>

        <a href="{{ route('zorg.measurements.create', $client) }}"
           class="inline-flex items-center px-4 py-2 rounded-md
                  bg-green-600 text-white hover:bg-green-700">
            <i class="fa fa-plus mr-2"></i>Nieuwe meting
        </a>
    </div>

    {{-- Metingen --}}
    <div class="space-y-4">
        @forelse($measurements as $measurement)

            @php
                // Fallbacks zodat er nooit "undefined variable" is
                $label = 'Onbekend';
                $badgeBg = 'bg-gray-100 text-gray-800';
                $icon = 'fa-stethoscope';

                switch ($measurement->type) {
                    case 'weight':
                        $label = 'Gewicht';
                        $badgeBg = 'bg-blue-100 text-blue-800';
                        $icon = 'fa-balance-scale';
                        break;

                    case 'blood_pressure':
                        $label = 'Bloeddruk';
                        $badgeBg = 'bg-red-100 text-red-800';
                        $icon = 'fa-heartbeat';
                        break;

                    case 'temperature':
                        $label = 'Temperatuur';
                        $badgeBg = 'bg-yellow-100 text-yellow-800';
                        $icon = 'fa-thermometer-half';
                        break;

                    case 'blood_sugar':
                        $label = 'Bloedsuiker';
                        $badgeBg = 'bg-purple-100 text-purple-800';
                        $icon = 'fa-tint';
                        break;
                }
            @endphp

            <div class="bg-white shadow rounded-lg p-4">

                <div class="flex justify-between items-start">
                    <div>
                        {{-- Sticker + titel --}}
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeBg }}">
                                <i class="fa {{ $icon }} mr-1"></i>{{ $label }}
                            </span>
                        </div>

                        <div class="text-xs text-gray-500 mt-1">
                            {{ optional($measurement->created_at)->format('d-m-Y H:i') }}
                            · door {{ $measurement->user->name ?? 'Onbekend' }}
                            @if($measurement->user_id === auth()->id())
                                <span class="ml-2 px-2 py-0.5 rounded-full bg-gray-100 text-gray-700"></span>
                            @endif
                        </div>
                    </div>

                    {{-- Acties (alleen eigen) --}}
                    @if($measurement->user_id === auth()->id())
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('zorg.measurements.edit', $measurement) }}"
                               class="text-blue-600 hover:text-blue-900">
                                Bewerken
                            </a>

                            <button type="button"
                                    class="text-red-600 hover:text-red-900 delete-btn"
                                    data-url="{{ route('zorg.measurements.destroy', $measurement) }}"
                                    data-label="{{ $label }}">
                                Verwijderen
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Waarden --}}
                <div class="mt-4 text-sm text-gray-700 space-y-1">
                    @if($measurement->type === 'weight')
                        <div>Gewicht: <strong>{{ $measurement->weight_kg ?? '—' }} kg</strong></div>
                        <div>Lengte: <strong>{{ $measurement->height_cm ?? '—' }} cm</strong></div>

                    @elseif($measurement->type === 'blood_pressure')
                        <div>Bovendruk: <strong>{{ $measurement->systolic ?? '—' }}</strong></div>
                        <div>Onderdruk: <strong>{{ $measurement->diastolic ?? '—' }}</strong></div>
                        <div>Hartslag: <strong>{{ $measurement->heart_rate ?? '—' }}</strong></div>

                    @elseif($measurement->type === 'temperature')
                        <div>Temperatuur: <strong>{{ $measurement->temperature_c ?? '—' }} °C</strong></div>

                    @elseif($measurement->type === 'blood_sugar')
                        <div>Bloedsuiker: <strong>{{ $measurement->blood_sugar ?? '—' }}</strong></div>

                    @else
                        <div class="text-gray-500">Geen details beschikbaar.</div>
                    @endif
                </div>

            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Nog geen metingen geregistreerd.
            </div>
        @endforelse
    </div>

</div>

<!-- ===== Delete Modal (popup) ===== -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Bevestigen</h2>

        <p class="text-gray-700 mb-6">
            Weet je zeker dat je deze meting (<span id="deleteMeasurementLabel" class="font-semibold"></span>) wilt verwijderen?
        </p>

        <div class="flex justify-end gap-3">
            <button type="button"
                    class="px-4 py-2 rounded-md border"
                    onclick="closeDeleteModal()">
                Annuleren
            </button>

            <button type="button"
                    class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700"
                    onclick="confirmDelete()">
                Ja, verwijderen
            </button>
        </div>
    </div>
</div>

<!-- Hidden delete form (1x) -->
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    let deleteUrl = '';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                deleteUrl = this.dataset.url;
                document.getElementById('deleteMeasurementLabel').textContent = this.dataset.label ?? 'meting';

                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    });

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteUrl = '';
    }

    function confirmDelete() {
        const form = document.getElementById('deleteForm');
        form.action = deleteUrl;
        form.submit();
    }
</script>
@endsection