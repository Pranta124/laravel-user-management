<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Attempt to log in with the provided credentials.
     *
     * @param array $credentials
     * @return mixed
     */

    public function attemptLogin(array $credentials): mixed
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        return null;
    }
}
