<?php


namespace App\Interfaces\Broker;

interface UnitRepositoryInterface
{
    public function getAll($brokerId);

    public function store($data);

    public function update($id, $data);

    public function findById($id);

    public function delete($id);
}
