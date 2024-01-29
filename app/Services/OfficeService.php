<?php

namespace App\Services;

use App\Models\Office;

class OfficeService
{
    public function registerOffice(array $data)
    {
        return Office::create($data);
    }
}
