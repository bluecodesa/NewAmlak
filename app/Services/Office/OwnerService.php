<?php
// app/Services/DeveloperService.php

namespace App\Services\Office;

use App\Repositories\Office\OwnerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OwnerService
{
    protected $OwnerRepository;

    public function __construct(OwnerRepository $OwnerRepository)
    {
        $this->OwnerRepository = $OwnerRepository;
    }

    public function getAllByOfficeId($officeId)
    {
        return $this->OwnerRepository->getAllByOfficeId($officeId);
    }

    public function getOwnerById($id)
    {
        return $this->OwnerRepository->getOwnerById($id);
    }

    public function createOwner($data)
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
        $Owner = $this->OwnerRepository->create($data);

        return $Owner;
    }

    public function updateOwner($id, $data)
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

        $Owner = $this->OwnerRepository->updateOwner($id, $data);

        return $Owner;
    }

    public function deleteOwner($id)
    {
        return $this->OwnerRepository->deleteOwner($id);
    }
}