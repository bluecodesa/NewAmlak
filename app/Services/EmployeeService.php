<?php
// app/Services/RegionService.php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getAll()
    {
        return Employee::all();
    }
    public function Delete($id)
    {
        return  Employee::find($id)->delete();
    }
}
