<?php

namespace App\Interfaces\Admin;

interface FalLicenseRepositoryInterface
{

    public function getAll();
    public function create($data);
    public function getById($data);
    public function update($id, $data);
    public function delete($id);
    public function createFalLicenseUser(array $data);
    public function updateFalLicenseUser($id, array $data);

    public function getUserLicenses($userId);
    public function getUnusedLicenseTypes($userId);
    public function getLicensesAllValid();

}
