<?php

namespace Soved\Laravel\Magic\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Soved\Laravel\Magic\Auth\Links\LinkBroker;

class AuthenticateWithMagicLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(
        $request,
        Closure $next,
        $guard = null
    ) {
        if (!Auth::guard($guard)->check()) {
            throw new AuthenticationException;
        }

        if (!Auth::guard($guard)->user()->viaMagicLink()) {
            $response = $this->sendMagicLinkEmail($request);

            Auth::guard($guard)->logout();

            return redirect()
                ->guest(route('login'))
                ->with('status', __($response));
        }

        return $next($request);
    }

    /**
     * Send a magic link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function sendMagicLinkEmail(Request $request)
    {
        return $this->broker()->sendMagicLink(
            [
                'email' => $request->user()->email,
            ]
        );
    }

    /**
     * Get the broker to be used during magic authentication.
     *
     * @return \Soved\Laravel\Magic\Auth\Links\LinkBroker
     */
    private function broker()
    {
        $userProvider = Auth::getProvider();

        return new LinkBroker($userProvider);
    }
}
