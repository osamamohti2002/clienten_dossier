@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Medewerker bewerken</h1>
            <p class="text-gray-600">Wijzig de gegevens van {{ $user->name }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form id="edit-employee-form"
                  action="{{ route('admin.users.update', $user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Naam -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Volledige naam *
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ $user->name }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            E-mailadres *
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ $user->email }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol *
                        </label>

                        <select name="role_id"
                                class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                    {{ $role->display_name ?? ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Telefoon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Telefoonnummer
                        </label>
                        <input type="tel"
                               name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Wachtwoord -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord
                        </label>
                        <input type="password"
                               name="password"
                               placeholder="Laat leeg om niet te wijzigen"
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Vul alleen in om wachtwoord te wijzigen</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}"
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