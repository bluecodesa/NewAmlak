<?php


namespace App\Interfaces\Broker;

interface DeveloperRepositoryInterface
{
    public function getAllByBrokerId($brokerId);

    public function create($data);

    public function find($id);

    public function update($id, $data);

    public function delete($id);
}
