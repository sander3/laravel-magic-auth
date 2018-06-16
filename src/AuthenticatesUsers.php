<?php

namespace Soved\Laravel\Magic\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Soved\Laravel\Magic\Auth\Links\LinkBroker;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Handle a magic authentication request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $response = $this->broker()->login(
            $request, function ($user) {
                $this->authenticateUser($user);
            }
        );

        return $response == LinkBroker::USER_AUTHENTICATED
            ? $this->sendLoginResponse($request)
            : $this->sendFailedLoginResponse($response);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Authenticate the given user.
     *
     * @param  \Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin  $user
     * @return void
     */
    protected function authenticateUser($user)
    {
        $this->guard()->login($user);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect($this->redirectPath());
    }

    /**
     * Get the failed login response instance.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedLoginResponse(string $response)
    {
        return redirect($this->redirectPath())
            ->with('status', __($response));
    }

    /**
     * Get the broker to be used during magic authentication.
     *
     * @return \Soved\Laravel\Magic\Auth\Links\LinkBroker
     */
    public function broker()
    {
        $userProvider = Auth::getProvider();

        return new LinkBroker($userProvider);
    }

    /**
     * Get the guard to be used during magic authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
