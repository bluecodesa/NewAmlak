<?php

namespace App\Services\Broker;

use App\Repositories\Broker\OwnerRepository;
use App\Interfaces\Broker\OwnerRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OwnerService
{
    protected $OwnerRepository;

    public function __construct(OwnerRepository $OwnerRepository)
    {
        $this->OwnerRepository = $OwnerRepository;
    }

    public function getAllByBrokerId($brokerId)
    {
        return $this->OwnerRepository->getAllByBrokerId($brokerId);
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
        $data['broker_id'] = Auth::user()->UserBrokerData->id;
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
