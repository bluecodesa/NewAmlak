<?php
// app/Services/DeveloperService.php

namespace App\Services\Office;

use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OwnerService
{
    protected $OwnerRepository;

    public function __construct(OwnerRepositoryInterface $OwnerRepository)
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
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'city_id' => 'required',
        //     'email' => [
        //         'required',
        //         'email',
        //         Rule::unique('owners'),
        //         'max:255'
        //     ],
        //     'phone' => [
        //         'required',
        //         Rule::unique('owners'),
        //         'max:25'
        //     ],
        // ];

        // validator($data, $rules)->validate();
        $data['office_id'] = auth()->user()->UserOfficeData->id;
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


    public function searchByIdNumber(Request $request)
    {
        // Perform validation
        $validatedData = $request->validate([
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ], [
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
        ]);
    
        $idNumber = $validatedData['id_number'];
        $officeId = auth()->user()->UserOfficeData->id;
    
        $user = User::where('id_number', $idNumber)->first();
    
        if ($user) {
            if ($user->is_owner) {
                $existingOwner = Owner::where('user_id', $user->id)
                    ->whereHas('brokers', function ($query) use ($officeId) {
                        $query->where('office_id', $officeId);
                    })
                    ->first();
    
                if ($existingOwner) {
                    return view('Office.ProjectManagement.Owner.inc._result_renter', [
                        'message' => __('Click on Client Data, cannot add again in the same account.'),
                        'user' => $user,
                        'id_number' => $idNumber
                    ]);
                } else {
                    return view('Office.ProjectManagement.Owner.inc.search-result-modal', [
                        'message' => __('Click on Client Data, Add as Owner the client has been added to the Owners list.'),
                        'user' => $user,
                        'id_number' => $idNumber
                    ]);
                }
            } else {
                return view('Office.ProjectManagement.Owner.inc.search-result-modal', [
                    'message' => __('Click on Client Data, Add as Owner the client has been added to the Owners list.'),
                    'user' => $user,
                    'id_number' => $idNumber
                ]);
            }
        } else {
            return view('Office.ProjectManagement.Owner.inc._addRenter', [
                'message' => __('This Owner is not registered'),
                'id_number' => $idNumber
            ]);
        }
    }
    
}
