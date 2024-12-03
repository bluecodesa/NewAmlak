<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\FalLicenseRepositoryInterface;
use App\Models\Fal;
use App\Models\FalLicenseUser;

class FalLicenseRepository implements FalLicenseRepositoryInterface
{
    public function getAll()
    {
        return Fal::paginate(100);
    }

    public function create($data)
{

    $data['for_gallery'] = isset($data['for_gallery']) ? 1 : 0;

    return Fal::create($data);
}


    function getById($id)
    {
        return Fal::find($id);
    }

    public function update($id, $data)
    {
        $Fal = Fal::findOrFail($id);
        $data['for_gallery'] = isset($data['for_gallery']) ? 1 : 0;

        $Fal->update($data);
        return $Fal;
    }

    public function delete($id)
    {
        return Fal::findOrFail($id)->delete();
    }


    public function createFalLicenseUser(array $data)
    {
        return FalLicenseUser::create($data);
    }

    public function updateFalLicenseUser($id, array $data)
    {
        $license = FalLicenseUser::findOrFail($id);
        $license->update($data);
        return $license;
    }

    public function getUserLicenses($userId)
    {
        return FalLicenseUser::where('user_id', $userId)->get();
    }
    public function getLicensesAllValid()
    {
         return FalLicenseUser::where('ad_license_status', 'valid')->get();

    }


    public function getUnusedLicenseTypes($userId)
    {
        $usedIds = FalLicenseUser::where('user_id', $userId)->pluck('fal_id');
        return Fal::whereNotIn('id', $usedIds)->get();
    }
}
