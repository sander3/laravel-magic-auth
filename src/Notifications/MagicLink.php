<?php

namespace Soved\Laravel\Magic\Auth\Notifications;

use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MagicLink extends Notification
{
    /**
     * The magic link.
     *
     * @var string
     */
    public $link;

    /**
     * Create a notification instance.
     *
     * @param  string  $link
     * @return void
     */
    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function via($notifiable)
    {
        return 'mail';
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::getFromJson('Magic Authentication Notification'))
            ->line(Lang::getFromJson('You are receiving this email because we received a magic authentication request for your account.'))
            ->action(Lang::getFromJson('Login'), $this->link)
            ->line(Lang::getFromJson('If you did not request a magic link, no further action is required.'));
    }
}
