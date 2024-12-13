<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskAssigned;



class TaskController extends Controller
{
    // Afficher la liste des tâches d'un projet
    public function index($projectId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }

        // Récupérer le projet en fonction de son ID
        $project = Project::findOrFail($projectId);

        // Récupérer les tâches associées au projet
        $tasks = $project->tasks;
        
        // Retourner la vue des tâches pour ce projet
        return view('tasks.index', compact('project', 'tasks'));
    }


    // Afficher le formulaire de création de tâche
    public function create($projectId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $project = Project::findOrFail($projectId);
        $users = User::all(); // Récupère tous les utilisateurs

        return view('tasks.create', compact('project', 'users'));
    }

    // Enregistrer une nouvelle tâche
    public function store(Request $request, $projectId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $task = new Task([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'status' => 'open',
            'project_id' => $projectId,
        ]);
        $task->save();

        // Assigner des utilisateurs à la tâche
        $task->users()->sync($request->users);

        // Envoyer une notification à chaque utilisateur assigné à la tâche
        foreach ($task->users as $user) {
            $user->notify(new TaskAssigned($task));  // Envoi de la notification
        }

        return redirect()->route('tasks.index', $projectId)->with('success', 'Tâche créée avec succès');
    }

    // Afficher les détails d'une tâche
    public function show($taskId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }    
        $task = Task::findOrFail($taskId);
        $project = $task->project; //relation avec le projet   
        return view('tasks.show', compact('task', 'project'));
    }

    // Afficher le formulaire de modification d'une tâche

    public function edit(Task $task)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        // Récupérer les utilisateurs pour les assigner à la tâche
        $users = User::all();

        return view('tasks.edit', compact('task', 'users'));
    }


    public function update(Request $request, Task $task)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string',
            'due_date' => 'nullable|date',
            'users' => 'array', // Validation pour les utilisateurs
        ]);

        // Mise à jour de la tâche
        $task->update($request->only('title', 'description', 'priority', 'due_date'));

        // Mettre à jour les utilisateurs assignés
        if ($request->has('users')) {
            $task->users()->sync($request->users);
        }

        // Rediriger vers la page de la tâche mise à jour
        return redirect()->route('tasks.show', $task->id)->with('success', 'Tâche mise à jour avec succès.');
    }

    // Supprimer une tâche
    public function destroy($taskId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $task = Task::findOrFail($taskId); // Récupère la tâche

        // Dissocier tous les utilisateurs associés à cette tâche
        $task->users()->detach();  // Détache tous les utilisateurs associés à la tâche via la table pivot

        // Supprimer la tâche
        $task->delete();

        return redirect()->route('tasks.index', $task->project_id)->with('success', 'Tâche supprimée avec succès');
    }

    // Clore une tâche (changer son statut)
    public function close($taskId)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'project_manager' ou 'team_member'
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'project_manager' && Auth::user()->role !== 'team_member') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }
        $task = Task::findOrFail($taskId);
        $task->status = 'closed';
        $task->save();

        return redirect()->route('tasks.index', $task->project_id)->with('success', 'Tâche fermée avec succès');
    }

    //Ajout de commentaires dans les tâches
    public function addComment(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId); // Trouver la tâche
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id(); // Utilisateur connecté
        $comment->task_id = $task->id;
        $comment->save(); // Enregistre le commentaire

        return redirect()->route('tasks.show', $taskId)->with('success', 'Commentaire ajouté');
    }

    public function notifyAboutDeadline($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Vérifier si la tâche approche de sa date limite, puis envoyer la notification
        if ($task->due_date->diffInDays(now()) <= 2) {  // 2 jours avant la deadline
            $task->user->notify(new TaskDeadlineNotification($task)); // Envoie la notification à l'utilisateur assigné
        }

        return redirect()->back()->with('success', 'Notification envoyée!');
    }

    public function assignTask($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        // Assigner la tâche à l'utilisateur
        $task->users()->attach($user);

        // Envoi de la notification
        $user->notify(new TaskAssigned());

        return redirect()->route('tasks.show', $task->id)->with('success', 'Tâche assignée et notification envoyée!');
    }

}
