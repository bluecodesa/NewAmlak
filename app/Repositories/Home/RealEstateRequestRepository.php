<?php

namespace App\Repositories\Home;

use App\Models\RealEstateRequest;

class RealEstateRequestRepository
{
    public function getAll()
    {
        return RealEstateRequest::all();
    }

    public function create($data)
    {
        return Owner::create($data);
    }

    function getRequestById($id)
    {
        return RealEstateRequest::findOrFail($id);
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
