@extends('layouts.app')

@section('content')


<div class="px-4 py-6 sm:px-0">
@if (session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">
        <div class="flex items-center">
            <i class="fa fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

    <!-- Title + add button -->
    <div class="flex items-center gap-4">
        <!-- Terug pijl -->
        <a href="{{ route('planner.dashboard') }}"
        class="text-gray-600 hover:text-gray-900"
        title="Terug">
            <i class="fa fa-arrow-left text-2xl"></i>
        </a>

        <!-- Titel -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Cliënten</h1>
            <p class="text-gray-600 mt-1">Beheer cliënten</p>
        </div>
    </div>


    <!-- Search -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('planner.clients.index') }}" class="max-w-md">
            <label class="block text-sm font-medium text-gray-700 mb-1">Zoeken</label>
            <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Zoek op naam..."
                    class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
        </form>
    </div>

    <!-- Clients table (placeholder) -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adres</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefoon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clients as $client)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $client->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $client->address ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $client->phone ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <a href="#"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fa fa-edit mr-1"></i>Bewerken
                                </a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-900 delete-btn"
                                        data-url="{{ route('planner.clients.destroy', $client->id) }}"
                                        data-name="{{ $client->name }}">
                                    <i class="fa fa-trash mr-1"></i>Verwijderen
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Nog geen cliënten. Klik op “Nieuwe cliënt” om te starten.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====== Delete Modal (1x) ====== -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Bevestigen</h2>

        <p class="text-gray-700 mb-6">
            Weet je zeker dat je <span id="deleteClientName" class="font-semibold"></span> wilt verwijderen?
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
                document.getElementById('deleteClientName').textContent = this.dataset.name;

                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        // optioneel: ESC sluit modal
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