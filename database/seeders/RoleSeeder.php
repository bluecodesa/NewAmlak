<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $super_admin=Role::create(['name' => 'App_SuperAdmin']);
        $admin = Role::create(['name' => 'Admin']);
        $rsOffice = Role::create(['name' => 'Rs_Admin']);
        $broker = Role::create(['name' => 'Broker']);
        $rsEmployee = Role::create(['name' => 'Rs_Employee']);
        $renter = Role::create(['name' => 'Renter']);

        $super_admin->givePermissionTo('subusers', 'support', 'subscriptions' , 'notifications',
        'payment_gateways');

        // $admin->givePermissionTo([
        //     'create-user',
        //     'edit-user',
        //     'delete-user',
        //     'create-product',
        //     'edit-product',
        //     'delete-product'
        // ]);

        // $rsOffice->givePermissionTo([
        //     'create-user',
        //     'edit-user',
        //     'delete-user',
        //     'create-product',
        //     'edit-product',
        //     'delete-product'
        // ]);

        // $rsEmployee->givePermissionTo([
        //     'create-product',
        //     'edit-product',
        //     'delete-product'
        // ]);
    }
}
