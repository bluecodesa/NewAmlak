<?php
// app/Services/DeveloperService.php

namespace App\Services\Office;

use App\Interfaces\Office\WalletRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WalletService
{
    protected $WalletRepository;

    public function __construct(WalletRepositoryInterface $WalletRepository)
    {
        $this->WalletRepository = $WalletRepository;
    }

    public function getAllByOfficeId($officeId)
    {
        return $this->WalletRepository->getAllByOfficeId($officeId);
    }

    public function getById($id)
    {
        return $this->WalletRepository->getById($id);
    }

    public function createWallet($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'initial_balance' => 'nullable|numeric',
            'is_default' => [
                'required',
                Rule::in(['0', '1'])
            ],
            'wallet_type_id' => 'required|exists:wallet_types,id',
        ];

        validator($data, $rules)->validate();

        $data['office_id'] = Auth::user()->UserOfficeData->id;
        $wallet = $this->WalletRepository->create($data);

        return $wallet;
    }


    public function updateWallet($id, $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'initial_balance' => 'nullable|numeric',
            'is_default' => [
                'required',
                Rule::in(['0', '1'])
            ],
            'wallet_type_id' => 'required|exists:wallet_types,id',
        ];

        validator($data, $rules)->validate();

        $wallet = $this->WalletRepository->updateWallet($id, $data);

        return $wallet;
    }


    public function deleteWallet($id)
    {
        return $this->WalletRepository->deleteWallet($id);
    }
}
