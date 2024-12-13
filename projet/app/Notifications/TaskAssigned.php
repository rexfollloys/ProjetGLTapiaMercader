<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskAssigned extends Notification
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
        return ['database', 'mail']; // Envoi dans la base de données et par email
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id, // ID de la tâche assignée
            'message' => 'Vous avez été assigné à la tâche: ' . $this->task->title 
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Vous avez une nouvelle tâche assignée.'. $this->task->title)
                    ->action('Voir la tâche', url('/tasks/' . $this->task->id))
                    ->line('Cordialement');
    }
}
