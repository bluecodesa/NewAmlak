<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Developer;

class DeveloperService
{
    public function getAll()
    {
        return Developer::all();
    }
    public function Delete($id)
    {
        return  Developer::find($id)->delete();
    }
}
