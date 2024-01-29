<?php

// app/Services/UserService.php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function registerUser(array $userData)
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'phone' => $userData['phone'],
            'whatsapp' => $userData['representative_whatsapp'],
            'is_security' => true, // You may set this based on your logic
        ]);

        // Your additional logic to handle company details, logo, etc.

        return $user;
    }
}
