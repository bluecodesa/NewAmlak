<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ServiceRepositoryInterface;
use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function getAll()
    {
        return Service::paginate(100);
    }

    public function create($data)
    {

        return Service::create($data);
    }

    function getById($id)
    {
        return Service::find($id);
    }

    public function update($id, $data)
    {
        $Service = Service::findOrFail($id);
        $Service->update($data);
        return $Service;
    }

    public function delete($id)
    {
        return Service::findOrFail($id)->delete();
    }
}