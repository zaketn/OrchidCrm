<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;

class NewTask extends Notification
{
    use Queueable;

    protected Task $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DashboardChannel::class];
    }

    /**
     * Get the Dashboard representation of the notification.
     *
     * @param $notifiable
     * @return DashboardMessage
     */
    public function toDashboard($notifiable)
    {
        return (new DashboardMessage)
            ->title('Для вас создана новая задача')
            ->message($this->task->project->name .': '. $this->task->header)
            ->action(route('platform.tasks.edit', $this->task));
    }
}
