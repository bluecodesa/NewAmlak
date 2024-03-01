<?php


namespace App\Interfaces\Broker;

interface OwnerRepositoryInterface
{
    public function getAllByBrokerId($brokerId);

    public function create($data);

    public function getOwnerById($id);

    public function updateOwner($id, $data);

    public function deleteOwner($id);
}
