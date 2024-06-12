<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Models\Owner;

class OwnerRepository implements OwnerRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {

        return Owner::where('office_id', $officeId)->get();
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
