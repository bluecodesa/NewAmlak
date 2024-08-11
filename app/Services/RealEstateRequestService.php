<?php

namespace App\Services;

use App\Repositories\Home\RealEstateRequestRepository;
use App\Interfaces\Home\RealEstateRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RealEstateRequestService
{
    protected $RealEstateRequestRepository;

    public function __construct(RealEstateRequestRepository $RealEstateRequestRepository)
    {
        $this->RealEstateRequestRepository = $RealEstateRequestRepository;
    }

    public function getAll()
    {
        return $this->RealEstateRequestRepository->getAll();
    }

    public function getRequestById($id)
    {
        return $this->RealEstateRequestRepository->getRequestById($id);
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
            'full_phone' => [
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
            'full_phone.required' => 'The phone field is required.',
            'full_phone.unique' => 'The phone has already been taken.',
            'full_phone.max' => 'The phone may not be greater than :max characters.',
        ];

        validator($data, $rules, $messages)->validate();
        $data['broker_id'] = Auth::user()->UserBrokerData->id;
        $Owner = $this->RealEstateRequestRepository->create($data);

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
            'full_phone' => [
                'required',
                Rule::unique('owners')->ignore($id),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();

        $Owner = $this->RealEstateRequestRepository->updateOwner($id, $data);

        return $Owner;
    }

    public function deleteOwner($id)
    {
        return $this->RealEstateRequestRepository->deleteOwner($id);
    }
}
