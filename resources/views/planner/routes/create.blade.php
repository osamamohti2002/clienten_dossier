@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">

    <!-- (Optional) Page title like dashboard style -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nieuwe route</h1>
            <p class="text-gray-600 mt-2">Vul de gegevens in om een nieuwe route te maken</p>
        </div>

        <a href="{{ route('planner.dashboard') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Terug
        </a>
    </div>

    <!-- New Route Form (same card design as your hidden one) -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Nieuwe route aanmaken</h3>
            <p class="mt-1 text-sm text-gray-500">Vul de gegevens in om een nieuwe route te maken</p>
        </div>

        <form method="POST" action="{{ route('planner.routes.store') }}">
            @csrf

            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Zorgmedewerker *</label>
                        <select name="zorgpersoneel_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm"
                                required>
                            <option value="">Selecteer zorgmedewerker</option>
                            @foreach($zorgpersoneel as $zp)
                                <option value="{{ $zp->id }}">
                                    {{ $zp->user->name ?? 'Onbekend' }}
                                </option>
                            @endforeach
                        </select>
                        @error('zorgpersoneel_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Datum *</label>
                        <input name="datum" type="date"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm"
                               required>
                        @error('datum')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Shift *</label>
                        <select name="shift"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm"
                                required>
                            <option value="ochtend">Ochtend</option>
                            <option value="avond">Avond</option>
                        </select>
                        @error('shift')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Starttijd *</label>
                        <input name="starttijd" type="time"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm"
                               value="08:30"
                               required>
                        @error('starttijd')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Eindtijd *</label>
                        <input name="eindtijd" type="time"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm"
                               value="09:30"
                               required>
                        @error('eindtijd')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Cliënten selecteren *</label>
                        <select name="clients[]" multiple
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm h-32"
                                required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->name }} ({{ $client->address }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Houd Ctrl ingedrukt om meerdere cliënten te selecteren</p>

                        @error('clients')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('clients.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('planner.dashboard') }}"
                       class="py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuleren
                    </a>

                    <button type="submit"
                            class="py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Route aanmaken
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
