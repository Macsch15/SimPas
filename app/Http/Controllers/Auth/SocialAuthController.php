<?php

namespace SimPas\Http\Controllers\Auth;

use SimPas\Http\Controllers\Controller;
use SimPas\User;
use Socialite;
use Auth;

class SocialAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider
     * @return Response
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $provider
     * @return Response
     */
    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $this->create($user);
        $this->auth($user);

        return redirect()->intended('/');
    }

    /**
     * Create a new user instance
     *
     * @param Laravel\Socialite\Two\User $user
     * @return User|bool
     */
    protected function create($user)
    {
        if (User::where('email', $user->getEmail())->exists() === true) {
            return true;
        }

        return User::create([
            'name' => $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => bcrypt($user->token),
        ]);
    }

    /**
     * Login attempt
     *
     * @param Laravel\Socialite\Two\User $user
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @return void
     */
    protected function auth($user)
    {
        $credentials = [
            'email' => $user->getEmail(),
            'password' => $user->token
        ];

        if (Auth::attempt($credentials) === false) {
            return abort(403);
        }
    }
}
