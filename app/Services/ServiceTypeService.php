<?php

namespace App\Services;

use App\Models\ServiceType;

class ServiceTypeService
{
    public function getAllServiceTypes()
    {
        return ServiceType::all();
    }
}
