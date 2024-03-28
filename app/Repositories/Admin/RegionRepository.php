<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RegionRepositoryInterface;
use App\Models\City;
use App\Models\Region;

class RegionRepository implements RegionRepositoryInterface
{
    public function getAllRegions()
    {
        return Region::get();
    }

    public function createRegion($data)
    {
        return Region::create($data);
    }

    function getRegionById($id)
    {
        return Region::find($id);
    }

    function getCityByRegionId($id)
    {
        return City::where('region_id', $id)->get();
    }

    public function update($id, $data)
    {
        $Region = Region::findOrFail($id);
        $Region->update($data);
        return $Region;
    }

    public function delete($id)
    {
        return Region::findOrFail($id)->delete();
    }
}
