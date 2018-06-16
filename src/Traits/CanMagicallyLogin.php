<?php

namespace Soved\Laravel\Magic\Auth\Traits;

use Soved\Laravel\Magic\Auth\Notifications\MagicLink as MagicLinkNotification;

trait CanMagicallyLogin
{
    /**
     * Get the e-mail address where magic links are sent.
     *
     * @return string
     */
    public function getEmailForMagicLink()
    {
        return $this->email;
    }

    /**
     * Send the magic link notification.
     *
     * @param  string  $link
     * @return void
     */
    public function sendMagicLinkNotification(string $link)
    {
        $this->notify(new MagicLinkNotification($link));
    }
}
