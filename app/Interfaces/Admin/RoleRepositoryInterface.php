<?php

namespace App\Interfaces\Admin;

interface RoleRepositoryInterface
{
    public function getAll();
    public function create($data);
    public function getById($data);
    public function ShowById($id);
    public function update($id, $data);
    public function delete($id);
}
