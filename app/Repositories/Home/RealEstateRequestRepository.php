<?php

namespace App\Repositories\Home;

use App\Models\RealEstateRequest;

class RealEstateRequestRepository
{
    public function getAll()
    {
        $userId=auth()->user()->id;
        $requests = RealEstateRequest::with(['requestStatuses' => function($query) use ($userId) {
            $query->where('user_id', $userId); 
        }])->get();
        return $requests;
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