<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\FalLicenseRepositoryInterface;
use App\Models\Fal;

class FalLicenseRepository implements FalLicenseRepositoryInterface
{
    public function getAll()
    {
        return Fal::paginate(100);
    }

    public function create($data)
    {
        return Fal::create($data);
    }

    function getById($id)
    {
        return Fal::find($id);
    }

    public function update($id, $data)
    {
        $Fal = Fal::findOrFail($id);
        $Fal->update($data);
        return $Fal;
    }

    public function delete($id)
    {
        return Fal::findOrFail($id)->delete();
    }
}
