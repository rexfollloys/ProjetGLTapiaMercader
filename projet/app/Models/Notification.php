<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    // Relation vers le modèle Task si nécessaire
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
