<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Créer une tâche pour le projet "{{ $project->name }}"
        </h2>
    </x-slot>

    @section('content')
    <div class="container mx-auto mt-6">
    <form action="{{ route('tasks.store', $project->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre de la tâche</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                <select name="priority" id="priority" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    <option value="low">Faible</option>
                    <option value="medium">Moyenne</option>
                    <option value="high">Haute</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                <input type="date" name="due_date" id="due_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="users" class="block text-sm font-medium text-gray-700">Affecter des utilisateurs</label>
                <select name="users[]" id="users" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->last_name }} -> ({{ $user-> email }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Créer la tâche
            </button>
        </form>
    </div>
    @endsection
</x-app-layout>
