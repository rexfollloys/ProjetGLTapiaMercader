@extends('layouts.app')

    @section('content')
        <div class="container mx-auto mt-6">
            <h1 class="text-2xl font-semibold mb-4 text-white">Modifier la tâche "{{ $task->title }}</h1>
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre de la tâche</label>
                    <input type="text" name="title" id="title" value="{{ $task->title }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $task->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                    <select name="priority" id="priority" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                        <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Faible</option>
                        <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Haute</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                    <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="users" class="block text-sm font-medium text-gray-700">Affecter des utilisateurs</label>
                    <select name="users[]" id="users" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" multiple required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->last_name }} -> ({{ $user-> email }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Mettre à jour la tâche
                </button>
            </form>
        </div>
    @endsection

