@extends('layouts.app')
    @section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4 text-white">Modifier le projet : {{ $project->name }}</h1>
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Champs de formulaire pré-remplis -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom du projet</label>
                <input type="text" name="name" id="name" value="{{ $project->name }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>{{ $project->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                <input type="date" name="start_date" id="start_date" value="{{ $project->start_date }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" name="end_date" id="end_date" value="{{ $project->end_date }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label for="users" class="block text-sm font-medium text-gray-700">Utilisateurs assignés</label>
                <select name="users[]" id="users" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" multiple required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ in_array($user->id, $project->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $user->last_name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
    @endsection

