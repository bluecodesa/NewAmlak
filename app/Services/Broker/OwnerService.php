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

        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'city_id.required' => 'The city field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.max' => 'The email may not be greater than :max characters.',
            'phone.required' => 'The phone field is required.',
            'phone.unique' => 'The phone has already been taken.',
            'phone.max' => 'The phone may not be greater than :max characters.',
        ];

        validator($data, $rules, $messages)->validate();
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
