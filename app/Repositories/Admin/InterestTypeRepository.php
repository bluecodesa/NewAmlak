<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\InterestTypeRepositoryInterface;
use App\Models\InterestType;

class InterestTypeRepository implements InterestTypeRepositoryInterface
{
    public function getAllInterestTypes()
    {
        return InterestType::get();
    }

    public function createInterestType($data)
    {
        return InterestType::create($data);
    }

    function getInterestTypeById($id)
    {
        return InterestType::find($id);
    }

    public function updateInterestType($id, $data)
    {
        $Interest = InterestType::findOrFail($id);
        $Interest->update($data);
        return $Interest;
    }

    public function deleteInterestType($id)
    {
        return InterestType::findOrFail($id)->delete();
    }
}
