<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\ContractRepositoryInterface;
use App\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {

        return Contract::where('office_id', $officeId)->get();
    }
    public function getAllByContractId($contractId)
    {

        return Contract::where('office_id', $contractId)->get();
    }


    public function create($data)
    {
        return Contract::create($data);
    }

    function getContractById($id)
    {
        return Contract::find($id);
    }

    public function updateContract($id, $data)
    {
        $Contract = Contract::findOrFail($id);
        $Contract->update($data);
        return $Contract;
    }

    public function deleteContract($id)
    {
        return Contract::findOrFail($id)->delete();
    }
}
