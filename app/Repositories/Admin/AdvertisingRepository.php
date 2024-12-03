<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Models\Advertising;

class AdvertisingRepository implements AdvertisingRepositoryInterface
{
    public function getAll()
    {
        return Advertising::all();
    }

    public function findById($id)
    {
        return Advertising::findOrFail($id);
    }

    public function create(array $data)
    {
        return Advertising::create($data);
    }

    public function update($id, array $data)
    {
        $advertising = $this->findById($id);
        $advertising->update($data);
        return $advertising;
    }

    public function delete($id)
    {
        $advertising = $this->findById($id);
        $advertising->delete();
    }
}
