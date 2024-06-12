<?php


namespace App\Interfaces\Office;

interface PropertyRepositoryInterface
{
    public function getAll($officeId);

    public function store($data, $images);

    public function update($id, $data, $images);

    public function StoreUnit($id, $data);

    public function autocomplete($data);

    public function findById($id);

    public function delete($id);
}
