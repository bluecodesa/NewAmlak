<?php


namespace App\Interfaces\Office;

interface UnitRepositoryInterface
{
    public function getAll($officeId);

    public function getAllByOffice($officeId);


    public function store($data);

    public function update($id, $data);

    public function findById($id);

    public function delete($id);
}