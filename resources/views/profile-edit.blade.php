@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Bewerk Profiel</h2>
                    <a href="{{ route('profile.view') }}" 
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
                        Terug
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Profielfoto</h4>
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                @if($user->avatar)
                                    <img id="avatar-preview" 
                                         src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="Profile Avatar"
                                         class="h-32 w-32 rounded-full object-cover border-4 border-gray-200">
                                @else
                                    <div id="avatar-preview" class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                                        <i class="fa fa-user text-gray-600 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Nieuwe Foto
                                </label>
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500">
                                <p class="mt-2 text-sm text-gray-500">Max 10MB</p>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-6">Persoonlijke Informatie</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Naam</label>
                                @if($user->role->name === 'admin')
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                @else
                                    <p class="mt-1 text-lg text-gray-900 bg-gray-100 p-3 rounded">{{ $user->name }}</p>
                                @endif
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                @if($user->role->name === 'admin')
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                @else
                                    <p class="mt-1 text-lg text-gray-900 bg-gray-100 p-3 rounded">{{ $user->email }}</p>
                                @endif
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefoon</label>
                                @if($user->role->name === 'admin')
                                    <input type="tel" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                @else
                                    <p class="mt-1 text-lg text-gray-900 bg-gray-100 p-3 rounded">{{ $user->phone ?? 'Niet opgegeven' }}</p>
                                @endif
                            </div>
                        </div>
                        @if($user->role->name !== 'admin')
                            <p class="mt-4 text-sm text-gray-500 italic">
                                <i class="fa fa-info-circle mr-1"></i>Alleen administrators kunnen persoonlijke informatie wijzigen
                            </p>
                        @endif
                    </div>

                    <!-- Password Change -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-6">Wijzig Wachtwoord</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Huidig wachtwoord</label>
                                <input type="password" 
                                       name="current_password"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nieuw wachtwoord</label>
                                <input type="password" 
                                       name="password"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bevestig wachtwoord</label>
                                <input type="password" 
                                       name="password_confirmation"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Delete Account (Admin only) -->
                    @if($user->role->name === 'admin')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                            <h4 class="text-xl font-semibold text-red-900 mb-4">Verwijder Account</h4>
                            <p class="text-red-700 mb-4">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                Waarschuwing: Dit verwijdert je account permanent.
                            </p>
                            <button type="button"
                                    onclick="confirmDelete()"
                                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="fa fa-trash-alt mr-2"></i>Account Verwijderen
                            </button>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.view') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Annuleer
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple Delete Modal -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold text-red-700 mb-2">Account verwijderen?</h2>
        <p class="text-gray-700 mb-6">Weet je het zeker? Dit kan niet ongedaan gemaakt worden.</p>
        
        <form id="deleteForm" action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Voer je wachtwoord in om te bevestigen</label>
                    <input type="password" 
                           name="password" 
                           required
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
                            onclick="closeDeleteModal()">
                        Annuleren
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-700">
                        Verwijderen
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Avatar preview
    document.getElementById('avatar').addEventListener('change', function(e) {
        const reader = new FileReader();
        const preview = document.getElementById('avatar-preview');
        
        reader.onload = function() {
            if (preview.tagName === 'IMG') {
                preview.src = reader.result;
            } else {
                const img = document.createElement('img');
                img.id = 'avatar-preview';
                img.src = reader.result;
                img.alt = 'Profile Avatar';
                img.className = 'h-32 w-32 rounded-full object-cover border-4 border-gray-200';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Delete modal
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection