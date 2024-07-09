<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {

        return Wallet::where('office_id', $officeId)->get();
    }

    public function create($data)
    {
        return Wallet::create($data);
    }

    function getById($id)
    {
        return Wallet::find($id);
    }

    public function updateWallet($id, $data)
    {
        $Wallet = Wallet::findOrFail($id);
        $Wallet->update($data);
        return $Wallet;
    }

    public function deleteWallet($id)
    {
        return Wallet::findOrFail($id)->delete();
    }
}
