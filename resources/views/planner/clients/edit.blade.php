@extends('layouts.app')

@section('content')
<div class="bg-gray-50 text-gray-800">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto mr-3 object-contain"
                             src="{{ asset('media/logo/ZorgSysteem_logo.png') }}"
                             alt="ZorgSysteem logo">
                        <span class="text-xl font-bold text-gray-900">ZorgSysteem</span>
                    </div>
                </div>

                <!-- Middle: nav buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('planner.dashboard') }}"
                       class="px-4 py-2 rounded-md border border-blue-600 text-blue-600 text-sm font-medium hover:bg-blue-50">
                        Routes
                    </a>

                    <a href="{{ route('planner.clients.index') }}"
                       class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Cliënten
                    </a>
                </div>

                <!-- Right: Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm rounded-full">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fa fa-user text-blue-600"></i>
                        </div>
                        <span class="ml-2 hidden md:block">
                            {{ auth()->user()->name ?? 'Planner' }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <i class="fa fa-sign-out mr-2"></i>Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Title -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Cliënt bewerken</h1>
                <p class="text-gray-600 mt-1">Wijzig de gegevens van {{ $client->name }}</p>
            </div>

            <!-- Edit Form -->
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('planner.clients.update', $client) }}" method="POST" class="space-y-6">
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

                    <!-- Bezoektijd -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bezoektijd</label>
                        <input type="time" name="visit_time" value="{{ old('visit_time', $client->visit_time) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm @error('visit_time') border-red-500 @enderror">
                        @error('visit_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
@endsection