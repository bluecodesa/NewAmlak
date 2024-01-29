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
            'name' => 'Super Admin Ezzat',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole('App_SuperAdmin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin Ezzat',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $rsOffice = User::create([
            'name' => 'User Ezzat',
            'email' => 'user@test.com',
            'password' => Hash::make('12345678')
        ]);
        $rsOffice->assignRole('Rs_Admin');

        $rsOffice = User::create([
            'name' => 'Broker',
            'email' => 'Broker@test.com',
            'password' => Hash::make('12345678')
        ]);
        $rsOffice->assignRole('Broker');
    }
}