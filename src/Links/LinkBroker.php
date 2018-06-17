<?php

namespace Soved\Laravel\Magic\Auth\Links;

use Closure;
use Illuminate\Http\Request;
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
            return static::INVALID_USER;
        }

        $user->sendMagicLinkNotification(
            $this->createMagicLink($user)
        );

        return static::MAGIC_LINK_SENT;
    }

    /**
     * Log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $callback
     * @return string
     */
    public function login(
        Request $request,
        Closure $callback
    ) {
        $user = $this->validateLogin($request);

        if (!$user instanceof CanMagicallyLoginContract) {
            return $user;
        }

        $callback($user);

        return static::USER_AUTHENTICATED;
    }

    /**
     * Validate a magic authentication request for the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin|string
     */
    protected function validateLogin(Request $request)
    {
        $credentials = $request->only('email');

        if (is_null($user = $this->getUser($credentials))) {
            return static::INVALID_USER;
        }

        if (!$request->hasValidSignature()) {
            return static::INVALID_SIGNATURE;
        }

        return $user;
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
        $email = $user->getEmailForMagicLink();

        return URL::temporarySignedRoute(
            'magic.login',
            now()->addMinutes(5), // To-do: create a config option
            [
                'email' => $email, // To-do: add more parameters for insurance
            ]
        );
    }
}
