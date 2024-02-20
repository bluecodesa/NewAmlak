<?php


namespace App\Interfaces\Broker;

interface ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId);

    public function create($data);

    public function update($id, $data);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data);
}
