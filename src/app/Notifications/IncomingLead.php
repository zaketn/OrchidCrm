<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;

class IncomingLead extends Notification
{
    use Queueable;

    /**
     * Lead instance.
     *
     * @var
     */
    protected Lead $lead;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
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
     * Get the Dashboard representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDashboard($notifiable)
    {
        return (new DashboardMessage)
                    ->title('Появился новый лид')
                    ->message($this->lead->header)
                    ->action('platform.leads.edit', $this->lead);
    }
}
