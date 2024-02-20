<?php
// app/Repositories/DeveloperRepository.php

namespace App\Repositories\Office;

use App\Interfaces\Office\DeveloperRepositoryInterface;
use App\Models\Developer;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;

class EmployeeRepository implements DeveloperRepositoryInterface
{
    protected $model;

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function getAllByOfficeId($officeId)
    {
        return Employee::where('office_id', $officeId)->get();
    }

    public function create($userData, $roleId, $employeeData)
    {
        $userData['password'] = bcrypt('12345678');
        $user = User::create($userData);
        $role = Role::find($roleId);
        $user->assignRole($role->name);

        return Employee::create($employeeData + ['user_id' => $user->id]);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $userData, $roleId, $employeeData)
    {
        $employee = $this->model->findOrFail($id);
        $user = $employee->UserData;
        $employee->update($employeeData);
        $user->roles()->sync($roleId);
        $user->update($userData);
        return $employee;
    }


    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
