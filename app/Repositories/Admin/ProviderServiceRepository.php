<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ProviderServiceRepositoryInterface;
use App\Models\ProviderService;
use App\Models\Wallet;

class ProviderServiceRepository implements ProviderServiceRepositoryInterface
{
    public function getAll()
    {
        return ProviderService::paginate(100);
    }

    public function create($data)
    {
        return ProviderService::create($data);
    }

    function getById($id)
    {
        return ProviderService::find($id);
    }

    public function update($id, $data)
    {
        $Wallet = ProviderService::findOrFail($id);
        $Wallet->update($data);
        return $Wallet;
    }

    public function delete($id)
    {
        return ProviderService::findOrFail($id)->delete();
    }
}
