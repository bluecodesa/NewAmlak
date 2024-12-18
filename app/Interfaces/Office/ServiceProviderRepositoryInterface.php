<?php


namespace App\Interfaces\Office;

interface ServiceProviderRepositoryInterface
{
    public function getAll();
    public function getAllByServiceProviderId($serviceProviderId);

    public function create($data);

    public function getById($id);

    public function update($id, $data);

    public function delete($id);
}
