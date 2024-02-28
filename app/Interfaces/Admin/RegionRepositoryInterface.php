<?php

namespace App\Interfaces\Admin;

interface RegionRepositoryInterface
{
    public function getAllRegions();
    public function createRegion($data);
    public function getRegionById($data);
    public function getCityByRegionId($id);
    public function update($id, $data);
    public function delete($id);
}
