<?php
// app/Repositories/DeveloperRepository.php

namespace App\Repositories\Broker;

use App\Models\Developer;

class DeveloperRepository
{
    public function getAllByBrokerId($brokerId)
    {
        return Developer::where('broker_id', $brokerId)->get();
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
        $developer = Developer::find($id);
        $developer->update($data);
        return $developer;
    }

    public function delete($id)
    {
        return Developer::destroy($id);
    }
}
