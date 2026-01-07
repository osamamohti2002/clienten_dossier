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
                        Back to Profile
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
                                        <i class="fa fa-user" aria-hidden="true"></i>

                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Nieuwe Foto
                                </label>
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-2 text-sm text-gray-500">JPEG, PNG, JPG or GIF (Max: 10MB)</p>
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
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Volledige Naam *</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Telefoon</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="+31 6 12345678">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Change (Optional) -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-6">Wijzig Wachtwoord</h4>
                        <div class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Huidig Wachtwoord</label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nieuw Wachtwoord</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password"
                                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Bevestig Nieuw Wachtwoord</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.view') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                            Annuleer
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Wijzigingen Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('avatar-preview');
    
    reader.onload = function() {
        if (preview.tagName === 'IMG') {
            preview.src = reader.result;
        } else {
            // Convert div to img
            const img = document.createElement('img');
            img.id = 'avatar-preview';
            img.src = reader.result;
            img.alt = 'Profile Avatar';
            img.className = 'h-32 w-32 rounded-full object-cover border-4 border-gray-200';
            preview.parentNode.replaceChild(img, preview);
        }
    }
    
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

// Attach the preview function to file input
document.getElementById('avatar').addEventListener('change', previewImage);
</script>
@endsection