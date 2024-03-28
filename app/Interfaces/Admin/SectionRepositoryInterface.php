<?php

namespace App\Interfaces\Admin;

interface SectionRepositoryInterface
{
    public function getAll();
    public function create($data);
    public function getById($data);
    public function update($id, $data);
    public function delete($id);
}
