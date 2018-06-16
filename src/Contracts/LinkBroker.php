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
     * Constant representing a successful magic login.
     *
     * @var string
     */
    const USER_AUTHENTICATED = 'magic.authenticated';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'magic.user';

    /**
     * Constant representing an invalid signature.
     *
     * @var string
     */
    const INVALID_SIGNATURE = 'magic.signature';

    /**
     * Send a magic link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendMagicLink(array $credentials);
}
