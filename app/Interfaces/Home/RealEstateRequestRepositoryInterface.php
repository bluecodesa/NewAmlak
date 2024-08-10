<?php


namespace App\Interfaces\Home;

interface RealEstateRequestRepositoryInterface
{
    public function getAll();

    public function getRequestById($id);

    public function create($data);

    public function getOwnerById($id);

    public function update($id, $data);

    public function delete($id);
}
