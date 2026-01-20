@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cliënten</h1>
        <p class="text-gray-600 mt-2">
            Zoek cliënten, bekijk gegevens en registreer rapportages of metingen
        </p>
    </div>

    <!-- Search -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('zorg.clients.index') }}" class="max-w-md">
            <label class="block text-sm font-medium text-gray-700 mb-1">Zoeken</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Zoek op naam of BSN..."
                   class="w-full border border-gray-300 rounded-md p-2 text-sm
                          focus:outline-none focus:ring-1 focus:ring-blue-500
                          focus:border-blue-500">
        </form>
    </div>

    <!-- Clients table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cliënt
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Telefoon
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Adres
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acties
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $client)
                    @php
                        $gender = $client->gender ?? 'unknown';
                        $genderBg = $gender === 'male' ? 'bg-blue-100' : ($gender === 'female' ? 'bg-pink-100' : 'bg-gray-100');
                        $genderIcon = $gender === 'male' ? 'fa-mars text-blue-600' : ($gender === 'female' ? 'fa-venus text-pink-600' : 'fa-user text-gray-500');
                    @endphp

                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                {{-- Gender icon --}}
                                <div class="h-10 w-10 flex-shrink-0 rounded-full flex items-center justify-center {{ $genderBg }}">
                                    <i class="fa {{ $genderIcon }}"></i>
                                </div>

                                {{-- Name + BSN --}}
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $client->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        BSN: {{ $client->bsn }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $client->phone ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $client->address ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                            {{-- Rapportage --}}
                            <a href="{{ route('zorg.reports.index', $client) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md border border-blue-300 text-blue-700 bg-blue-50 hover:bg-blue-100 mr-2">
                                    <i class="fa fa-file-text mr-2"></i>Rapportage
                            </a>

                            {{-- Metingen (placeholder) --}}
                            <a href="{{ route('zorg.measurements.index', $client) }}"
                               class="inline-flex items-center px-3 py-1.5 rounded-md
                                      border border-green-300 text-green-700
                                      bg-green-50 hover:bg-green-100">
                                <i class="fa fa-heartbeat mr-2"></i>Metingen
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Geen cliënten gevonden.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection