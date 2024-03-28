<?php

namespace App\Services;

use App\Models\User;

class UserCreationService
{
    public function createBroker(array $userData)
    {
        return User::create([
            'is_broker' => 1,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'user_name' => uniqid(),
            'password' => bcrypt($userData['password']),
            'avatar' => $userData['broker_logo'] ?? null,

        ]);
    }

    public function createOffice(array $userData)
    {
        return User::create([
            'is_office' => 1,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'user_name' => uniqid(),
            'password' => bcrypt($userData['password']),
            'avatar' => $userData['company_logo'],
        ]);
    }
}
