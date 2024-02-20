<?php


namespace App\Interfaces\Office;

interface ProjectRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data);

    public function update($id, $data);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data);
}
