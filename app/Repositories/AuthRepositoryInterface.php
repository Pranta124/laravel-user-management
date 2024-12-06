<?php

namespace App\Repositories;

/**
 * Interface for authentication-related methods.
 * Acts as a contract for implementing the repository.
 */
interface AuthRepositoryInterface
{
    /**
     * Verify user credentials and return user details.
     *
     * @param array $credentials
     * @return mixed
     */
    public function attemptLogin(array $credentials): mixed;
}
