<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;

class InvitingToProject extends Notification
{
    use Queueable;

    /**
     * Project instance
     *
     * @var Project
     */
    public Project $project;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DashboardChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDashboard($notifiable)
    {
        return (new DashboardMessage)
                    ->title('Приглашение в проект')
                    ->message('Проект: '. $this->project->name)
                    ->action(route('platform.projects.edit', $this->project));
    }
}
