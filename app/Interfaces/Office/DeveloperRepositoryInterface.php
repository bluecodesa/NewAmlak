<?php


namespace App\Interfaces\Office;

interface DeveloperRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data);

    public function find($id);

    public function update($id, $data);

    public function delete($id);
}
