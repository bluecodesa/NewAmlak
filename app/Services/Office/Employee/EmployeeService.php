<?php
// app/Services/DeveloperService.php

namespace App\Services\Employee;

use App\Interfaces\Office\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeService
{
    protected $EmployeeRepository;

    public function __construct(EmployeeRepositoryInterface $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }

    public function getAllByOfficeId($officeId)
    {
        return $this->EmployeeRepository->getAllByOfficeId($officeId);
    }

    public function find($id)
    {
        return $this->EmployeeRepository->find($id);
    }

    public function create($userData, $roleId, $employeeData)
    {
        $rules = [
            'name' => 'required|string|max:255',
            // 'city_id' => 'required|exists:cities,id',
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
        validator($userData, $rules)->validate();
        $employeeData['office_id'] = Auth::user()->UserOfficeData->id;
        $employee = $this->EmployeeRepository->create($userData, $roleId, $employeeData);
        return $employee;
    }

    public function update($id, $userData, $roleId, $employeeData)
    {
        $user =  $this->EmployeeRepository->find($id)->UserData;
        $rules = [
            'name' => 'required|string|max:255',
            // 'city_id' => 'required|exists:cities,id',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                'max:25'
            ],
        ];
        validator($userData, $rules)->validate();
        $employeeData['office_id'] = Auth::user()->UserOfficeData->id;
        $employee = $this->EmployeeRepository->update($id, $userData, $roleId, $employeeData);
        return $employee;
    }


    public function delete($id)
    {
        return $this->EmployeeRepository->delete($id);
    }
}
