<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getAllCities()
    {
        return City::all();
    }
}
