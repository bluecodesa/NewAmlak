<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'user_name' => 'super_admin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole('App_SuperAdmin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin',
            'user_name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $rsOffice = User::create([
            'name' => 'User',
            'user_name' => 'user',
            'email' => 'user@test.com',
            'password' => Hash::make('12345678')
        ]);
        $rsOffice->assignRole('Rs_Admin');

        $broker = User::create([
            'name' => 'Broker',
            'user_name' => 'broker',
            'email' => 'Broker@test.com',
            'password' => Hash::make('12345678')
        ]);
        $broker->assignRole('Broker');
    }
}
