@extends('layouts.app')

    @section('content')  <!-- Début de la section de contenu -->

    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4 text-white">Créer un projet</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <!-- Formulaire pour le projet -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom du projet</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required></textarea>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="users" class="block text-sm font-medium text-gray-700">Assigner des utilisateurs</label>
                <select name="users[]" id="users" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" multiple required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                            {{ $user->last_name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    Créer le projet
                </button>
            </div>
        </form>
    </div>
    @endsection

