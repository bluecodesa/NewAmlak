<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $permissions = [
            'owners',
            'projects',
            'renters',
            'accountant',
            'CRM',
            'bills',
            'tells',
            'subusers',
            'support',
            'subscriptions',
            'security',
            'notifications',
            'payment_gateways',

         ];
        // $permissions = [
        //     'owners',
        //     'projects',
        //     'renters',
        //     'accountant',
        //     'CRM',
        //     'bills',
        //     'tells',
        //     'subusers',
        //     'support',
        //     'subscriptions',
        //     'security',
        //     'create-role',
        //     'edit-role',
        //     'delete-role',
        //     'create-user',
        //     'edit-user',
        //     'delete-user',
        //     'create-product',
        //     'edit-product',
        //     'delete-product'
        //  ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
