<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $taskId)
    {
        // Validation des données du commentaire
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Trouver la tâche correspondante
        $task = Task::findOrFail($taskId);

        // Ajouter un nouveau commentaire à la tâche
        $task->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        // Rediriger vers la tâche avec un message de succès
        return redirect()->route('tasks.show', $taskId)->with('success', 'Commentaire ajouté avec succès!');
    }
}

