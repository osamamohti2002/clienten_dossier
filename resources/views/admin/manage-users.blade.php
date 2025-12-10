@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Medewerkersbeheer</h1>
        <p class="text-gray-600 mt-2">Overzicht van alle medewerkers</p>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Naam
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            E-mail
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full 
                                        @if($user->role === 'admin') bg-purple-100
                                        @elseif($user->role === 'planner') bg-green-100
                                        @else bg-yellow-100 @endif 
                                        flex items-center justify-center mr-3">
                                        <i class="fa 
                                            @if($user->role === 'admin') fa-user text-purple-600
                                            @elseif($user->role === 'planner') fa-calendar text-green-600
                                            @else fa-user-md text-yellow-600 @endif 
                                            text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($user->role === 'admin') bg-purple-100 text-purple-800
                                    @elseif($user->role === 'planner') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Simple Info -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Totaal: {{ $users->count() }} medewerker(s)
            </p>
        </div>
    </div>
</div>
@endsection