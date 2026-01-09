@extends('layouts.app')

@section('content')
<div class="fade-in">
    <div class="px-4 py-6 sm:px-0">
        <!-- Dashboard Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-2">Technisch beheer van medewerkers en autorisaties</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <dt class="text-sm font-medium text-gray-500 truncate">Totaal cliënten</dt>
                    <dd class="mt-1 text-5xl font-semibold text-gray-900">142</dd>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <dt class="text-sm font-medium text-gray-500 truncate">Totaal medewerkers</dt>
                    <dd class="mt-1 text-5xl font-semibold text-gray-900">{{ $totalUsers }}</dd>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <dt class="text-sm font-medium text-gray-500 truncate">Totaal routes vandaag</dt>
                    <dd class="mt-1 text-5xl font-semibold text-gray-900">63</dd>
                </div>
            </div>
        </div>

        <!-- Personnel Management -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Personeelsbeheer</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Beheer alle medewerkers</p>
                </div>

                <a href="{{ route('admin.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    <i class="fa fa-users mr-2"></i>Nieuwe medewerker toevoegen
                </a>
            </div>

            <!-- Search Form -->
            <div class="px-4 py-3 bg-gray-50 border-t border-b border-gray-200">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="max-w-xs">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                               name="search"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Zoek medewerker..."
                               value="{{ request('search') }}">
                    </div>
                </form>
            </div>

            <!-- Personnel Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full
                                        @if($user->role->name === 'admin') bg-purple-100
                                        @elseif($user->role->name === 'planner') bg-green-100
                                        @else bg-yellow-100 @endif
                                        flex items-center justify-center">
                                        <i class="fa
                                            @if($user->role->name === 'admin') fa-user text-purple-600
                                            @elseif($user->role->name === 'planner') fa-calendar text-green-600
                                            @else fa-user-md text-yellow-600 @endif"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($user->role->name === 'admin') bg-purple-100 text-purple-800
                                    @elseif($user->role->name === 'planner') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $user->role->display_name ?? ucfirst($user->role->name) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{route('admin.users.edit', $user->id) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3 inline-flex items-center">
                                    <i class="fa fa-edit mr-1"></i>Bewerken
                                </a>
                                {{-- <button type="button" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fa fa-edit mr-1"></i>Bewerken
                                </button> --}}

                                <!-- Delete knop (opent modal) -->
                                <button type="button"
                                        class="text-red-600 hover:text-red-900 delete-btn"
                                        data-url="{{ route('admin.users.destroy', $user->id) }}"
                                        data-name="{{ $user->name }}">
                                    <i class="fa fa-trash-alt mr-1"></i>Verwijderen
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    @if($users->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Geen medewerkers gevonden
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- ====== Custom Delete Modal (1x op pagina) ====== -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Bevestigen</h2>

        <p class="text-gray-700 mb-6">
            Weet je zeker dat je <span id="deleteUserName" class="font-semibold"></span> wilt verwijderen?
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
                Bevestigen
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
    document.addEventListener('DOMContentLoaded', function() {
        const addEmployeeForm = document.getElementById('add-employee-form');

        // Add Employee Form Toggle
        const addEmployeeBtn = document.getElementById('add-employee-btn');
        if (addEmployeeBtn && addEmployeeForm) {
            addEmployeeBtn.addEventListener('click', function() {
                addEmployeeForm.classList.toggle('hidden');
            });
        }

        // Cancel Add Employee
        const cancelAddEmployeeBtn = document.getElementById('cancel-add-employee');
        if (cancelAddEmployeeBtn && addEmployeeForm) {
            cancelAddEmployeeBtn.addEventListener('click', function() {
                addEmployeeForm.classList.add('hidden');
            });
        }
    });
</script>

<script>
    let deleteUrl = '';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                deleteUrl = this.dataset.url;
                document.getElementById('deleteUserName').textContent = this.dataset.name;

                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
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

