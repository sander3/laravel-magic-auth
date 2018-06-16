<?php

namespace Soved\Laravel\Magic\Auth\Contracts;

interface CanMagicallyLogin
{
    /**
     * Get the e-mail address where magic links are sent.
     *
     * @return string
     */
    public function getEmailForMagicLink();

    /**
     * Send the magic link notification.
     *
     * @param  string  $link
     * @return void
     */
    public function sendMagicLinkNotification(string $link);
}
