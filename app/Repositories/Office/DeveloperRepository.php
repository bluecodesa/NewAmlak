<?php
// app/Repositories/DeveloperRepository.php

namespace App\Repositories\Office;

use App\Interfaces\Office\DeveloperRepositoryInterface;
use App\Models\Developer;

class DeveloperRepository implements DeveloperRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {
        return Developer::where('office_id', $officeId)->get();
    }

    public function create($data)
    {
        return Developer::create($data);
    }

    public function find($id)
    {
        return Developer::find($id);
    }

    public function update($id, $data)
    {
        $developer = Developer::findOrFail($id);
        $developer->update($data);
        return $developer;
    }

    public function delete($id)
    {
        return Developer::destroy($id);
    }
}
