<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\WalletTypeRepositoryInterface;
use App\Models\Wallet;
use App\Models\WalletType;

class WalletTypeRepository implements WalletTypeRepositoryInterface
{
    public function getAll()
    {
        return WalletType::paginate(100);
    }

    public function create($data)
    {
        return WalletType::create($data);
    }

    function getById($id)
    {
        return WalletType::find($id);
    }

    public function update($id, $data)
    {
        $Wallet = WalletType::findOrFail($id);
        $Wallet->update($data);
        return $Wallet;
    }

    public function delete($id)
    {
        return WalletType::findOrFail($id)->delete();
    }
}
