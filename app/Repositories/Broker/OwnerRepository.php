<?php

namespace App\Repositories\Broker;

use App\Models\Owner;

class OwnerRepository
{
    public function getAllByBrokerId($brokerId)
    {
        return Owner::where('broker_id', $brokerId)->get();
    }

    public function create($data)
    {
        return Owner::create($data);
    }

    function getOwnerById($id)
    {
        return Owner::find($id);
    }

    public function updateOwner($id, $data)
    {
        $Owner = Owner::findOrFail($id);
        $Owner->update($data);
        return $Owner;
    }

    public function deleteOwner($id)
    {
        return Owner::findOrFail($id)->delete();
    }
}
