<?php

namespace App\Interfaces\Admin;

use Illuminate\Http\Request;

interface AdvertisingRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}