<?php
// app/Services/PropertyUsageService.php

namespace App\Services;

use App\Models\PropertyUsage;

class PropertyUsageService
{
    public function getAllPropertyUsages()
    {
        return PropertyUsage::all();
    }
}
