<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationSetting::create([
            'notification_name' => 'Payment_due_date',
            'email' => 1,
            'whatsapp' => 1,
            'sms' => 1,
        ]);

        NotificationSetting::create([
            'notification_name' => 'Add_new_tenant',
            'email' => 1,
            'whatsapp' => 1,
            'sms' => 1,
        ]);
        NotificationSetting::create([
            'notification_name' => 'Make_rent_payment',
            'email' => 1,
            'whatsapp' => 1,
            'sms' => 1,
        ]);
    }
}
