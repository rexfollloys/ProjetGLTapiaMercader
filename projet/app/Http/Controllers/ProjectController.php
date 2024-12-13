<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // L'administrateur voit tous les projets
            $projects = Project::all();
        } else {
            // Les chefs de projet et les membres d'équipe ne voient que les projets auxquels ils sont assignés
            $projects = Auth::user()->projects;
        }
    
        return view('projects.index', compact('projects'));
    }

    public function create()
    {

        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        // Formulaire pour créer un projet
        $users = User::all();
        return view('projects.create', compact('users'));

    }

    public function store(Request $request)
    {

        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }


        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'users' => 'required|array', // S'assurer que des utilisateurs sont sélectionnés
            'users.*' => 'exists:users,id', // Chaque utilisateur sélectionné doit exister
        ]);

        // Création du projet
        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        // Associer les utilisateurs sélectionnés au projet
        $project->users()->sync($request->input('users')); // Si aucun utilisateur sélectionné, on envoie un tableau vide

        // Redirection avec message de succès
        return redirect()->route('dashboard')->with('success', 'Projet créé avec succès et utilisateurs assignés.');
    }

    public function show(Project $project)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }

        // Vérifier si l'utilisateur actuel est assigné à ce projet
        if (Auth::user()->role !== 'admin' && !Auth::user()->projects->contains($project)) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à voir ce projet.');
        }
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $users = User::all();
        $project->load('users');
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {

        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' 
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'users' => 'array'
        ]);
       $project->update($request->only('name', 'description', 'start_date', 'end_date'));

       // Met à jour les utilisateurs assignés
       $project->users()->sync($request->input('users', []));

       return redirect()->route('projects.show', $project) ->with('success', 'Projet mis à jour avec succès.');
   }

   // app/Http/Controllers/ProjectController.php

   public function destroy($id)
   {
       // Vérification si l'utilisateur a le rôle 'admin' ou 'project manager'
       if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager') {
           return redirect()->route('dashboard')->with('error', 'Accès interdit!');
       }
   
       // Trouver le projet par son ID
       $project = Project::findOrFail($id);

        // Dissocier les utilisateurs associés aux tâches
        foreach ($project->tasks as $task) {
            $task->users()->detach();  // Dissocie tous les utilisateurs de la tâche
        }
       // Supprimer toutes les tâches liées à ce projet
       $project->tasks()->delete();
       // Supprimer le projet
       $project->delete();
   
       // Rediriger vers la page des projets avec un message de succès
       return redirect()->route('dashboard')->with('success', 'Le projet a été supprimé avec succès.');
   }

}
