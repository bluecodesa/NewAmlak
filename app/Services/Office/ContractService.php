<?php
// app/Services/DeveloperService.php

namespace App\Services\Office;

use App\Interfaces\Office\ContractRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContractService
{
    protected $ContractRepository;

    public function __construct(ContractRepositoryInterface $ContractRepository)
    {
        $this->ContractRepository = $ContractRepository;
    }

    public function getAllByOfficeId($officeId)
    {
        return $this->ContractRepository->getAllByOfficeId($officeId);
    }

    public function getContractById($id)
    {
        return $this->ContractRepository->getContractById($id);
    }

    public function createContract($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('owners'),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('owners'),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();
        $data['office_id'] = Auth::user()->UserOfficeData->id;
        $Contract = $this->ContractRepository->create($data);

        return $Contract;
    }

    public function updateContract($id, $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('owners')->ignore($id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('owners')->ignore($id),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();

        $Contract = $this->ContractRepository->updateContract($id, $data);

        return $Contract;
    }

    public function deleteContract($id)
    {
        return $this->ContractRepository->deleteContract($id);
    }
}
