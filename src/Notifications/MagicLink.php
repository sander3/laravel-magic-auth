<?php

namespace Soved\Laravel\Magic\Auth\Notifications;

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
     * @param string $link
     */
    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    public function via($notifiable)
    {
        return 'mail';
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('Magic Authentication Notification'))
            ->line(__('You are receiving this email because we received a magic authentication request for your account.'))
            ->action(__('Login'), $this->link)
            ->line(__('If you did not request a magic link, no further action is required.'));
    }
}
