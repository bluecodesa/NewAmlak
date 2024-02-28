<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PropertyTypeRepositoryInterface;
use App\Models\PropertyType;

class PropertyTypeRepository implements PropertyTypeRepositoryInterface
{
    public function getAll()
    {
        return PropertyType::get();
    }

    public function create($data)
    {
        return PropertyType::create($data);
    }

    function getById($id)
    {
        return PropertyType::find($id);
    }

    public function update($id, $data)
    {
        $PropertyType = PropertyType::findOrFail($id);
        $PropertyType->update($data);
        return $PropertyType;
    }

    public function delete($id)
    {
        return PropertyType::findOrFail($id)->delete();
    }
}
