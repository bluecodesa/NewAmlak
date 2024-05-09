<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\DistrictRepositoryInterface;
use App\Models\District;

class DistrictRepository implements DistrictRepositoryInterface
{
    public function getAllDistrict()
    {
        return District::paginate(500);
    }

    public function createDistrict($data)
    {
        return District::create($data);
    }

    function getDistrictById($id)
    {
        return District::find($id);
    }

    public function getDistrictsByCity($cityId)
    {
        return District::where('city_id', $cityId)->get();
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
