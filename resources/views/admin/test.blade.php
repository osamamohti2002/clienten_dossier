
<!-- <!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Create User Form</title>

<style>
    body{
        font-family: Arial, sans-serif;
        background:#f5f5f5;
        display:flex;
        align-items:center;
        justify-content:center;
        height:100vh;
    }
    form{
        background:white;
        padding:20px;
        width:320px;
        border-radius:8px;
        box-shadow:0 0 10px rgba(0,0,0,0.1);
    }
    label{
        font-weight:bold;
        display:block;
        margin-top:15px;
    }
    input, select{
        width:100%;
        padding:8px;
        margin-top:5px;
        border-radius:5px;
        border:1px solid #ccc;
    }
    button{
        margin-top:20px;
        width:100%;
        padding:10px;
        background:#007bff;
        color:white;
        border:none;
        border-radius:5px;
        cursor:pointer;
        font-size:16px;
    }
    button:hover{
        background:#0056b3;
    }
</style>

</head>
<body>

<form action="{{ route('admin.store') }}" method="post">
    @csrf
    <h2>Nieuwe gebruiker</h2>

    <label>Naam</label>
    <input type="text" name="naam" value="{{ old('naam') }}" required>

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>

    <label>Wachtwoord</label>
    <input type="password" name="password" required>

    <label>Rol</label>
    <select name="role_id" required> <!-- Changed from "rol" to "role_id" -->
        <!-- <option value="">Selecteer een rol</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>

    <button type="submit">Gebruiker aanmaken</button>  -->
<!-- </form> -->
<!-- 
@if(session('success'))
    <div style="color: green; margin-top: 10px; text-align: center;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="color: red; margin-top: 10px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

<!-- </body>
</html> -->


@extends('layouts.app')

@section('content')
<div class="bg-gray-50 p-6 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Nieuwe medewerker</h1>
            <p class="text-gray-600">Voeg een nieuwe medewerker toe aan het systeem</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Naam -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Naam *
                        </label>
                        <input type="text" name="naam" value="{{ old('naam') }}" required
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            E-mailadres *
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Wachtwoord -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord *
                        </label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Minimaal 6 karakters</p>
                    </div>

                    <!-- Wachtwoord bevestigen -->



                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wachtwoord bevestigen *
                        </label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol *
                        </label>
                        <select name="role_id" required
                                class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            <option value="">Selecteer een rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Annuleren
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fa fa-user-plus mr-2"></i>Medewerker aanmaken
                    </button>
                </div>
            </form>

            <!-- Success message -->
            @if(session('success'))
                <div class="text-green-600 mt-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error messages -->
            @if($errors->any())
                <div class="text-red-600 mt-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
