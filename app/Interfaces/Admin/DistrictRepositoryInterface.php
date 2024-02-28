<?php

namespace App\Interfaces\Admin;

interface DistrictRepositoryInterface
{
    public function getAllDistrict();
    public function createDistrict($data);
    public function getDistrictById($data);
    public function update($id, $data);
    public function delete($id);
}
