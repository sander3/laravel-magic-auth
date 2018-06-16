<?php

namespace Soved\Laravel\Magic\Auth\Links;

use UnexpectedValueException;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\UserProvider;
use Soved\Laravel\Magic\Auth\Contracts\LinkBroker as LinkBrokerContract;
use Soved\Laravel\Magic\Auth\Contracts\CanMagicallyLogin as CanMagicallyLoginContract;

class LinkBroker implements LinkBrokerContract
{
    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $users;

    /**
     * Create a new magic link broker instance.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $users
     * @return void
     */
    public function __construct(UserProvider $users)
    {
        $this->users = $users;
    }

    /**
     * Send a magic link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendMagicLink(array $credentials)
    {
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            // To-do: send user not found notification:
            return;
        }

        $user->sendMagicLinkNotification(
            $this->createMagicLink($user)
        );

        return static::MAGIC_LINK_SENT;
    }

    /**
     * Get the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin|null
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials)
    {
        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && !$user instanceof CanMagicallyLoginContract) {
            throw new UnexpectedValueException('User must implement CanMagicallyLogin interface.');
        }

        return $user;
    }

    /**
     * Create a new magic link.
     *
     * @param  \Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin  $user
     * @return string
     */
    public function createMagicLink(CanMagicallyLoginContract $user)
    {
        $email = $user->getEmailForPasswordReset();

        return URL::temporarySignedRoute(
            'magic.login',
            now()->addMinutes(5),
            [
                'email' => $email,
            ]
        );
    }
}
