<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ServiceTypeRepositoryInterface;
use App\Models\PropertyUsage;
use App\Models\ServiceType;

class ServiceTypeRepository implements ServiceTypeRepositoryInterface
{
    public function getAll()
    {
        return ServiceType::paginate(100);
    }

    public function create($data)
    {
        return ServiceType::create($data);
    }

    function getById($id)
    {
        return ServiceType::find($id);
    }

    public function update($id, $data)
    {
        $ServiceType = ServiceType::findOrFail($id);
        $ServiceType->update($data);
        return $ServiceType;
    }

    public function delete($id)
    {
        return ServiceType::findOrFail($id)->delete();
    }
}