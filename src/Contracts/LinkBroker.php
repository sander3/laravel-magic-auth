<?php

namespace Soved\Laravel\Magic\Auth\Contracts;

interface LinkBroker
{
    /**
     * Constant representing a successfully sent magic link.
     *
     * @var string
     */
    const MAGIC_LINK_SENT = 'magic.link_sent';

    /**
     * Send a magic link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendMagicLink(array $credentials);
}
