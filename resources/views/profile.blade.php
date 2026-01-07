@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Uw Profiel</h2>
                    <a href="{{ route('profile.edit') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Bewerk Profiel
                    </a>
                </div>

                <div class="space-y-8">
                    <!-- Avatar Section -->
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="Profile Avatar"
                                     class="h-32 w-32 rounded-full object-cover border-4 border-gray-200">
                            @else
                                <div class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                                    <i class="fa fa-user" aria-hidden="true"></i>

                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->role->name ?? 'User' }}</p>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Persoonlijke Informatie</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Volledige Naam</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Telefoon</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->phone ?? 'Niet Opgegeven' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Registratie Datum</label>
                                <p class="mt-1 text-lg text-gray-900">
                                    @if($user->created_at)
                                        {{ $user->created_at->format('F d, Y') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection