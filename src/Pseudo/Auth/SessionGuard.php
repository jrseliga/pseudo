<?php

namespace Pseudo\Auth;

use Pseudo\Contracts\GuestContract;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\SessionGuard as LaravelSessionGuard;

class SessionGuard extends LaravelSessionGuard
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! $this->user() instanceof GuestContract;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        $user = parent::user();

        if (is_null($user)) {
            $user = resolve(GuestContract::class);
        }

        return $user;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function authenticate()
    {
        $user = $this->user();

        if (! $user instanceof GuestContract) {
            return $user;
        }

        throw new AuthenticationException;
    }
}
