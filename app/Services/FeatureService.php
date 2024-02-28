<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Feature;

class FeatureService
{
    public function getAllFeature()
    {
        return Feature::all();
    }
}
