<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence, // Un titre aléatoire
            'description' => $this->faker->paragraph, // Une description aléatoire
            'due_date' => $this->faker->date(), // Une date d'échéance aléatoire
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']), // Priorité
            'status' => $this->faker->randomElement(['open', 'closed', 'in-progress']), // Statut
            'project_id' => Project::factory(), // Associe la tâche à un projet existant
        ];
    }
}
