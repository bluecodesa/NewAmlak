<?php


namespace App\Interfaces\Employee;

interface ProjectRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data, $files);

    public function update($id, $data, $images);

    public function ShowProject($id);

    public function delete($id);

    public function storeProperty($data, $images);

    public function StoreUnit($id, $data);
    public function autocomplete($data);
}
