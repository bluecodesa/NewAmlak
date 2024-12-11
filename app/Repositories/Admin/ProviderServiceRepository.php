<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ProviderServiceRepositoryInterface;
use App\Models\ProviderServiceType;
use App\Models\Wallet;

class ProviderServiceRepository implements ProviderServiceRepositoryInterface
{
    public function getAll()
    {
        return ProviderServiceType::paginate(100);
    }

    public function create($data)
    {
        return ProviderServiceType::create($data);
    }

    function getById($id)
    {
        return ProviderServiceType::find($id);
    }

    public function update($id, $data)
    {
        $Wallet = ProviderServiceType::findOrFail($id);
        $Wallet->update($data);
        return $Wallet;
    }

    public function delete($id)
    {
        return ProviderServiceType::findOrFail($id)->delete();
    }
}
