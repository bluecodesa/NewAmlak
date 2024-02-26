<?php


namespace App\Interfaces\Broker;

interface ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId);

    public function create($data, $images);

    public function update($id, $data, $images);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data, $id, $images);
}
