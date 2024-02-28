<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Advisor;

class AdvisorService
{
    public function getAll()
    {
        return Advisor::all();
    }

    public function Delete($id)
    {
        return  Advisor::find($id)->delete();
    }
}
