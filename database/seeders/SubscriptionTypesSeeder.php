<?php

// database/seeders/SubscriptionTypesSeeder.php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\SubscriptionType;

class SubscriptionTypesSeeder extends Seeder
{
    public function run()
    {
        SubscriptionType::insert([
            [
                'is_deleted' => 0,
                'period' => 1,
                'period_type' => 'day',
                'price' => '0',
                'status' => '1',
                'created_at' => '2023-04-02 10:34:16',
                'updated_at' => '2023-09-24 21:12:27',
            ],
            [
                'is_deleted' => 0,
                'period' => 1,
                'period_type' => 'week',
                'price' => '0',
                'status' => '1',
                'created_at' => '2023-04-02 10:34:16',
                'updated_at' => '2023-09-24 21:12:27',
            ],
            [
                'is_deleted' => 0,
                'period' => 3,
                'period_type' => 'month',
                'price' => '185',
                'status' => '0',
                'created_at' => '2023-10-04 17:40:42',
                'updated_at' => '2023-10-04 17:40:42',
            ],
            [
                'is_deleted' => 0,
                'period' => 1,
                'period_type' => 'year',
                'price' => '410',
                'status' => '1',
                'created_at' => '2023-10-16 12:26:09',
                'updated_at' => '2023-10-16 12:26:09',
            ],
            [
                'is_deleted' => 0,
                'period' => 6,
                'period_type' => 'month',
                'price' => '60',
                'status' => '1',
                'created_at' => '2023-04-18 11:42:16',
                'updated_at' => '2023-09-24 21:12:40',
            ],
            // Add more data entries as needed
        ]);
    }
}
