<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        <a href="{{ route('projects.show', $project->id) }}"  class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Détails du projet</a>
        <a href="{{ route('tasks.index', $project->id) }}"  class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Liste des tâches</a>
        <a href=""  class="text-blue-500 hover:text-blue-700">Recapitulatif du temps</a>
    </h2>
</x-slot>


    @section('content')
    <div class="container mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

            <!-- Header Section -->
            <div class="bg-indigo-600 p-6">
                <h1 class="text-3xl font-semibold text-white">Détails de la tâche</h1>
            </div>

            <div class="p-6 space-y-6">
                <!-- Task Title and Description -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $task->title }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $task->description }}</p>
                </div>

                <!-- Task Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold">Priorité</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-{{ $task->priority === 'low' ? 'green' : ($task->priority === 'medium' ? 'yellow' : 'red') }}-500 rounded-full">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold">Date d'échéance</p>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $task->due_date }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold">Statut</p>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($task->status) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="{{ route('tasks.edit', $task->id) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                        Modifier
                    </a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                            Supprimer
                        </button>
                    </form>

                    <form action="{{ route('tasks.close', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Clore la tâche
                        </button>
                    </form>

                    <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Assigner du temps
                    </button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Commentaires</h2>
                <div class="comments-section max-h-60 overflow-y-auto space-y-4">
                    @forelse(optional($task->comments)->reverse() as $comment)
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $comment->user->last_name }}</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                            <small class="text-xs text-gray-500 dark:text-gray-400">Publié le : {{ \Carbon\Carbon::parse($comment->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</small>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Aucun commentaire pour l'instant.</p>
                    @endforelse
                </div>

                <form action="{{ route('comments.add', $task->id) }}" method="POST" class="mt-4">
                    @csrf
                    <textarea name="content" placeholder="Ajoutez un commentaire..." class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:ring-indigo-500"></textarea>
                    <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
