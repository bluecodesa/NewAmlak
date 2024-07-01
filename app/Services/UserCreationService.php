<?php

namespace App\Services;

use App\Models\User;

class UserCreationService
{
    public function createBroker(array $userData)
    {
        $Last_customer_id = User::where('customer_id', '!=', null)->latest()->value('customer_id');
        $delimiter = '-';
        $prefixes = ['AMK1-', 'AMK2-', 'AMK3-', 'AMK4-', 'AMK5-', 'AMK6-'];
        if (!$Last_customer_id) {
            $new_customer_id = 'AMK1-0001';
        } else {
            $result = explode($delimiter, $Last_customer_id);
            $number = (int)$result[1] + 1;
            $tag_index = min(intval($number / 1000), count($prefixes) - 1);
            $tag = $prefixes[$tag_index];
            $new_customer_id = $tag . str_pad($number % 1000, 4, '0', STR_PAD_LEFT);
        }

        return User::create([
            'is_broker' => 1,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'user_name' => uniqid(),
            'customer_id' => $new_customer_id,
            'password' => bcrypt($userData['password']),
            'avatar' => $userData['broker_logo'] ?? null,

        ]);
    }

    public function createOffice(array $userData)
    {
        $Last_customer_id = User::where('customer_id', '!=', null)->latest()->value('customer_id');
        $delimiter = '-';
        $prefixes = ['AMK1-', 'AMK2-', 'AMK3-', 'AMK4-', 'AMK5-', 'AMK6-'];
        if (!$Last_customer_id) {
            $new_customer_id = 'AMK1-0001';
        } else {
            $result = explode($delimiter, $Last_customer_id);
            $number = (int)$result[1] + 1;
            $tag_index = min(intval($number / 1000), count($prefixes) - 1);
            $tag = $prefixes[$tag_index];
            $new_customer_id = $tag . str_pad($number % 1000, 4, '0', STR_PAD_LEFT);
        }


        return User::create([
            'is_office' => 1,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'key_phone' => $userData['key_phone'],
            'full_phone' => $userData['full_phone'],
            'user_name' => uniqid(),
            'customer_id' => $new_customer_id,
            'password' => bcrypt($userData['password']),
            'avatar' => $userData['company_logo'] ?? null,
        ]);
    }
}
