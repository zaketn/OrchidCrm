<?php

namespace App\Notifications;

use App\Models\Meetup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;

class ArrangedMeetup extends Notification
{
    use Queueable;

    /**
     * Meetup instance
     *
     * @var
     */
    protected Meetup $meetup;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Meetup $meetup)
    {
        $this->meetup = $meetup;
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
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDashboard($notifiable)
    {
        return (new DashboardMessage)
            ->title('Организована новая встреча с вашем участием')
            ->message($this->meetup->address.', '.$this->meetup->place.', '.datetime_format($this->meetup->date_time))
            ->action(route('platform.meetups.edit', $this->meetup));
    }
}
