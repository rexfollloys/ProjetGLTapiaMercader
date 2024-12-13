<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

/*
Laravel fournit un système de notifications intégré utilisable pour envoyer des messages.
*/
class TaskDeadlineNotification extends Notification
{
    private $task;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    // Constructeur pour passer les données de la tâche
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Choisissez les canaux (mail, database, etc.)
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Deadline de la tâche')
                    ->line('La tâche "' . $this->task->title . '" arrive bientôt à sa date limite.')
                    ->action('Voir la tâche', url('/tasks/' . $this->task->id))
                    ->line('Cordialement');
    }

    // Notification dans la base de données
    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'message' => 'La tâche arrive bientôt à sa date limite.'
        ];
    }
}
