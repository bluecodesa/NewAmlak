<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\DistrictRepositoryInterface;
use App\Models\District;

class DistrictRepository implements DistrictRepositoryInterface
{
    public function getAllDistrict()
    {
        return District::get();
    }

    public function createDistrict($data)
    {
        return District::create($data);
    }

    function getDistrictById($id)
    {
        return District::find($id);
    }

    public function update($id, $data)
    {
        $District = District::findOrFail($id);
        $District->update($data);
        return $District;
    }

    public function delete($id)
    {
        return District::findOrFail($id)->delete();
    }
}