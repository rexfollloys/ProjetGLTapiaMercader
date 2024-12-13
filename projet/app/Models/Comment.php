<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
    Le modèle Eloquent dans Laravel est un outil de gestion des bases 
    de données qui permet d'interagir avec la base de données de manière orientée objet.
    Il permet de manipuler les données sous forme d'objets et non sous forme de requêtes SQL brutes.
*/

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'content'];

    // Relation avec la tâche (chaque commentaire appartient à une tâche)
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relation avec l'utilisateur (chaque commentaire appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
