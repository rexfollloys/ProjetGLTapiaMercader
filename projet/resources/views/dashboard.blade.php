@extends('layouts.app')

    <!-- permet de placer le contenu dans le layout de manière dynamique-->
    @section('content')  <!-- Début de la section de contenu -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold mb-4 text-white">Tableau de bord</h1>
            <!-- Bouton Ajouter un projet uniquement visible par l'admin et project_manager-->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'project_manager')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('projects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                        Ajouter un projet
                    </a>
                </div>
            @endif
            <div class="container mt-4">
                <h2 class="text-xl font-bold  text-white rounded-lg">Notifications</h2>
                <div class="notifications">
                    @foreach(auth()->user()->notifications as $notification)
                        <div class="notification bg-gray-800 text-white rounded-lg p-4 mb-4 relative">
                            <!-- Bouton de suppression (croix) -->
                            <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white hover:text-red-500">
                                    &times; <!-- croix -->
                                </button>
                            </form>

                            <p>{{ $notification->data['message'] }}</p>

                            <a href="{{ url('/tasks/' . $notification->data['task_id']) }}" class="text-cyan-400 hover:text-cyan-500">
                                Voir la tâche
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="container mx-auto mt-6">
            <!-- Liste des projets -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $project->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $project->description }}</p>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    Status:
                                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">
                                        {{ $project->status }}
                                    </span>
                                </p>

                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">
                                    Dates:
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">
                                        {{ $project->start_date }} - {{ $project->end_date }}
                                    </span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-4">
                                <!-- Bouton pour consulter les détails du projet -->
                                    <a href="{{ route('projects.show', $project->id) }} "
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mt-4">
                                        Consulter les détails
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>

    @endsection  <!-- Fin de la section de contenu -->

