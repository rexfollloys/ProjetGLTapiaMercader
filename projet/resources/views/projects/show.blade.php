<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        <a href="{{ route('projects.show', $project->id) }}"  class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Détails du projet</a>
        <a href="{{ route('tasks.index', $project->id) }}"  class="text-blue-500 hover:text-blue-700" style="margin-right: 70px;">Liste des tâches</a>
        <a href=""  class="text-blue-500 hover:text-blue-700">Recapitulatif du temps</a>
    </h2>
</x-slot>

@section('content')
<div class="py-12">
    <div class="grid grid-cols-1 gap-4">
        <!-- Détails du projet -->
        <div id="details-section" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <!-- Contenu aligné avec le titre -->
            <div class="mt-6 flex justify-between items-center">
                <!-- Titre du projet -->
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $project->name }}</h3>
                <!-- Boutons alignés à droite -->
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'project_manager')
                    <div class="flex space-x-4">
                        <a href="{{ route('projects.edit', $project->id) }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">
                            Modifier le projet
                        </a>


                        <!-- Formulaire pour supprimer -->
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">
                                Supprimer le projet
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Description du projet -->
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $project->description }}</p>

            <!-- Marge entre la description et l'état -->
            <p class="text-sm text-gray-500 dark:text-gray-300 mt-4">
                Statut :
                <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">
                    {{ $project->status }}
                </span>
            </p>

            <!-- Dates du projet -->
            <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">
                Dates : <span class="font-semibold">{{ $project->start_date }} - {{ $project->end_date }}</span>
            </p>

            <!-- Utilisateurs assignés -->
            <div class="mt-4">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Utilisateurs assignés :</h4>
                <ul class="mt-2">
                    @foreach($project->users as $user)
                        <li class="text-gray-600 dark:text-gray-300">{{ $user->last_name }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
</x-app-layout>
