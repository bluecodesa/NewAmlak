<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionsAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // JSON data as a string (you could also load this from a file)
        $jsonData = '{
            "regions": [
              {
                "name": "الرياض",
                "cities": ["الرياض", "الخرج", "الدرعية"]
              },
              {
                "name": "مكة المكرمة",
                "cities": ["مكة", "جدة", "الطائف"]
              },
              {
                "name": "المدينة المنورة",
                "cities": ["المدينة المنورة", "ينبع", "العلا"]
              },
              {
                "name": "القصيم",
                "cities": ["بريدة", "عنيزة", "الرس"]
              },
              {
                "name": "الشرقية",
                "cities": ["الدمام", "الخبر", "الأحساء"]
              },
              {
                "name": "عسير",
                "cities": ["أبها", "خميس مشيط", "بيشة"]
              },
              {
                "name": "تبوك",
                "cities": ["تبوك", "الوجه", "ضباء"]
              },
              {
                "name": "حائل",
                "cities": ["حائل", "بقعاء"]
              },
              {
                "name": "الحدود الشمالية",
                "cities": ["عرعر", "رفحاء", "طريف"]
              },
              {
                "name": "جازان",
                "cities": ["جازان", "صبيا", "أبو عريش"]
              },
              {
                "name": "نجران",
                "cities": ["نجران", "شرورة", "حبونا"]
              },
              {
                "name": "الباحة",
                "cities": ["الباحة", "المندق", "بلجرشي"]
              },
              {
                "name": "الجوف",
                "cities": ["سكاكا", "القريات", "دومة الجندل"]
              }
            ]
          }
          ';

        // Decode the JSON data to an array
        $data = json_decode($jsonData, true);

        // Iterate over the regions and insert them along with their cities
        foreach ($data['regions'] as $regionData) {
            $region = Region::create([
                'ar' => ['name' => $regionData['name']],
                'en' => ['name' => $regionData['name'] . '_en']
            ]);

            foreach ($regionData['cities'] as $cityName) {
                City::create([
                    'ar' => ['name' => $cityName],
                    'en' => ['name' => $cityName . '_en'],
                    'region_id' => $region->id
                ]);
            }
        }
    }
}
