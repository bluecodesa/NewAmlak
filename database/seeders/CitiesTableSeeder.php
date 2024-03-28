<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        City::insert([
            ['name' => 'مدينة الرياض'],
            ['name' => 'جدة'],
            ['name' => 'مكة المكرمة'],
            // Add more cities as needed
        ]);
    }
}
