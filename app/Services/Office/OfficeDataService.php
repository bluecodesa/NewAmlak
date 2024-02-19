<?php
// app/Services/OfficeDataService.php

namespace App\Services\Office;

use App\Models\Advisor;
use App\Models\Developer;
use App\Models\Employee;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;

class OfficeDataService
{
    public function getAdvisors()
    {
        return Advisor::where('office_id', Auth::user()->UserOfficeData->id)->get();
    }

    public function getDevelopers()
    {
        return Developer::where('office_id', Auth::user()->UserOfficeData->id)->get();
    }

    public function getOwners()
    {
        return Owner::where('office_id', Auth::user()->UserOfficeData->id)->get();
    }

    public function getEmployees()
    {
        return Employee::where('office_id', Auth::user()->UserOfficeData->id)->get();
    }
}
