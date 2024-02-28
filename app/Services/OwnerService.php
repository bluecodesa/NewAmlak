<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Owner;

class OwnerService
{
    public function getAll()
    {
        return Owner::all();
    }
    public function Delete($id)
    {
        return  Owner::find($id)->delete();
    }
}
