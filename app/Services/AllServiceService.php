<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Service;

class AllServiceService
{
    public function getAllServices()
    {
        return Service::all();
    }
}