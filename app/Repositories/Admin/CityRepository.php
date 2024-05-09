<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CityRepositoryInterface;
use App\Models\City;

class CityRepository implements CityRepositoryInterface
{
    public function getAllCities()
    {
        return City::paginate(500);
    }

    public function createCity($data)
    {
        return City::create($data);
    }

    function getCityById($id)
    {
        return City::find($id);
    }

    public function update($id, $data)
    {
        $city = City::findOrFail($id);
        $city->update($data);
        return $city;
    }

    public function delete($id)
    {
        return City::findOrFail($id)->delete();
    }
}
