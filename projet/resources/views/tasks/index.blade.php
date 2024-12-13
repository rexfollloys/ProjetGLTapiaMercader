<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Détails du projet</a>
        <a href="{{ route('tasks.index', $project->id) }}" class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Liste des tâches</a>
        <a href="" class="text-blue-500 hover:text-blue-700">Recapitulatif du temps</a>
    </h2>
</x-slot>
@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bouton pour ajouter une tâche -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('tasks.create', $project->id) }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    Ajouter une tâche
                </a>
            </div>

            <!-- Liste des tâches -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-left">Titre</th>
                            <th class="px-6 py-3 text-left">Priorité</th>
                            <th class="px-6 py-3 text-left">Date d'échéance</th>
                            <th class="px-6 py-3 text-left">Statut</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-300">
                        @foreach ($tasks as $task)
                            <tr class="border-t border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $task->title }}</td>
                                <td class="px-6 py-4">{{ ucfirst($task->priority) }}</td>
                                <td class="px-6 py-4">{{ $task->due_date }}</td>
                                <td class="px-6 py-4">{{ ucfirst($task->status) }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                                        Consulter les détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
</x-app-layout>
