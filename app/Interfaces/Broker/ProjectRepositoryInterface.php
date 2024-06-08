<?php


namespace App\Interfaces\Broker;

interface ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId);

    public function getAllByOfficeId($brokerId);

    public function create(array $data, array $files);

    public function update($id, $data, $images);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data, $id, $images);
    public function StoreUnit($id, $data);
    public function autocomplete($data);


}
