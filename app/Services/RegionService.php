<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Region;

class RegionService
{
    public function getAllRegions()
    {
        return Region::all();
    }
}
