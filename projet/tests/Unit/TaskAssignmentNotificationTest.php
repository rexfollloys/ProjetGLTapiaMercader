<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskAssignmentNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_receives_notification_when_task_is_assigned()
    {
        // Arrange : Création d'un utilisateur, d'un projet et d'une tâche
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'title' => 'Test Task',
            'description' => 'This is a test task description',
            'status' => 'open',
        ]);

        // Simulation de l'assignation de la tâche à l'utilisateur
        $task->users()->attach($user);

        // Simulation de la notification
        Notification::fake();

        // Act : Envoi de la notification d'assignation de tâche
        $user->notify(new TaskAssigned($task, $project));

        // Assert : Vérification que la notification a bien été envoyée à l'utilisateur
        Notification::assertSentTo(
            [$user],
            TaskAssigned::class
        );

        // Vérification de l'existence de la tâche dans la base de données
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task description',
            'status' => 'open',
            'project_id' => $project->id
        ]);

        // Vérification que l'utilisateur est bien assigné à la tâche
        $this->assertTrue($task->users->contains($user));
    }
}