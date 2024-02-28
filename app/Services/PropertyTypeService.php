<?php
// app/Services/PropertyTypeService.php

namespace App\Services;

use App\Models\PropertyType;

class PropertyTypeService
{
    public function getAllPropertyTypes()
    {
        return PropertyType::all();
    }
}
