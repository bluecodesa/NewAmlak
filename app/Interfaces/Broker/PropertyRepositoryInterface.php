<?php


namespace App\Interfaces\Broker;

interface PropertyRepositoryInterface
{
    public function getAll($brokerId);

    public function store($data, $images);

    public function update($id, $data, $images);

    public function findById($id);

    public function delete($id);
}
