<?php

namespace App\Interfaces\Admin;

interface CityRepositoryInterface
{
    public function getAllCities();
    public function createCity($data);
    public function getCityById($data);
    public function update($id, $data);
    public function delete($id);
}
