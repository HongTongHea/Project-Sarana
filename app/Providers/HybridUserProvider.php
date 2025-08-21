<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HybridUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // TODO: find user by ID
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: find user by ID and "remember me" token
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: update "remember me" token
    }

    public function retrieveByCredentials(array $credentials)
    {
        // TODO: find user by email/username
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: check user password or external auth
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // Laravel 11 requires this.
        // Usually: rehash password if algorithm has changed.
        // For now, you can just return false or implement actual rehash.
        return false;
    }
}
