<?php


namespace App\Interfaces\Office;

interface OwnerRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data);

    public function getOwnerById($id);

    public function updateOwner($id, $data);

    public function deleteOwner($id);
}
