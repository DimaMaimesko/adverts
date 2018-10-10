<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as ProviderUser;

class ProviderService
{
    public function auth(string $provider, ProviderUser $data): User
    {
        if ($user = User::byProvider($provider, $data->getId())->first()) {
            return $user;
        }

        if ($data->getEmail() && $user = User::where('email', $data->getEmail())->exists()) {
            throw new \DomainException('User with this email is already registered.');
        }

        $user = DB::transaction(function () use ($provider, $data) {
            return User::registerByProvider($provider, $data);
        });

        //event(new Registered($user));

        return $user;
    }
}
