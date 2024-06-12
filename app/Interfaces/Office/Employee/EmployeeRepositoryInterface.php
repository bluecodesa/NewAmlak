<?php


namespace App\Interfaces\Office;

interface EmployeeRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($userData, $roleId, $employeeData);

    public function find($id);

    public function update($id, $userData, $roleId, $employeeData);

    public function delete($id);
}
