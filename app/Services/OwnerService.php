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

    public function getNumberOfOwners($id)
{
    $numberOfOwners = Owner::where(function ($query) use ($id) {
        $query->where('broker_id', $id)
              ->orWhere('office_id', $id);
    })->count();

    return $numberOfOwners;
}


}
