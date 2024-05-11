<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PropertyUsageRepositoryInterface;
use App\Models\District;
use App\Models\PropertyUsage;

class PropertyUsageRepository implements PropertyUsageRepositoryInterface
{
    public function getAll()
    {
        return PropertyUsage::paginate(100);
    }

    public function create($data)
    {
        return PropertyUsage::create($data);
    }

    function getById($id)
    {
        return PropertyUsage::find($id);
    }

    public function update($id, $data)
    {
        $PropertyUsage = PropertyUsage::findOrFail($id);
        $PropertyUsage->update($data);
        return $PropertyUsage;
    }

    public function delete($id)
    {
        return PropertyUsage::findOrFail($id)->delete();
    }
}