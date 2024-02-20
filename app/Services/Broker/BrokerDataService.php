<?php
// app/Services/BrokerDataService.php

namespace App\Services\Broker;

use App\Models\Advisor;
use App\Models\Developer;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;

class BrokerDataService
{
    public function getAdvisors()
    {
        return Advisor::where('broker_id', Auth::user()->UserBrokerData->id)->get();
    }

    public function getDevelopers()
    {
        return Developer::where('broker_id', Auth::user()->UserBrokerData->id)->get();
    }

    public function getOwners()
    {
        return Owner::where('broker_id', Auth::user()->UserBrokerData->id)->get();
    }


}
