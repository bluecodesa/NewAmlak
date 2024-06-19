<?php
// app/Services/DeveloperService.php

namespace App\Services\Office;

use App\Interfaces\Office\RenterRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RenterService
{
    protected $RenterRepository;

    public function __construct(RenterRepositoryInterface $RenterRepository)
    {
        $this->RenterRepository = $RenterRepository;
    }

    public function getAllByOfficeId($officeId)
    {
        return $this->RenterRepository->getAllByOfficeId($officeId);
    }

    public function getRenterById($id)
    {
        return $this->RenterRepository->getRenterById($id);
    }

    public function createRenter($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users'),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('users'),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();
        // $data['office_id'] = Auth::user()->UserOfficeData->id;
        $Renter = $this->RenterRepository->create($data);

        return $Renter;
    }

    public function updateRenter($id, $data)
    {
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'city_id' => 'required',
        //     'email' => [
        //         'required',
        //         'email',
        //         Rule::unique('owners')->ignore($id),
        //         'max:255'
        //     ],
        //     'phone' => [
        //         'required',
        //         Rule::unique('owners')->ignore($id),
        //         'max:25'
        //     ],
        // ];

        // validator($data, $rules)->validate();

        $Renter = $this->RenterRepository->updateRenter($id, $data);

        return $Renter;
    }

    public function deleteRenter($id)
    {
        return $this->RenterRepository->deleteRenter($id);
    }
}
