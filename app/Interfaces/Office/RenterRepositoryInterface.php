<?php


namespace App\Interfaces\Office;

interface RenterRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data);

    public function getRenterById($id);

    public function updateRenter($id, $data);

    public function deleteRenter($id);
}
