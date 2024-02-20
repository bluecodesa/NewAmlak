<?php


namespace App\Interfaces\Office;

interface ProjectRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data, $images);

    public function update($id, $data, $images);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data, $images);
}
