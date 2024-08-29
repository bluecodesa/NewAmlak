<?php
// app/Services/BrokerDataService.php

namespace App\Services\Broker;

use App\Models\Advisor;
use App\Models\Developer;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Property;
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

    public function getOwnersHome()
    {
        return Owner::where('broker_id', Auth::user()->UserBrokerData->id)->get();
    }

    public function getOwners()
    {
        // Assuming the authenticated user is a broker
        $broker = Auth::user()->UserBrokerData;

        // Retrieve owners associated with the broker
        return $broker->owners;
    }
    public function getProjects()
    {
        return Project::where('broker_id', Auth::user()->UserBrokerData->id)->get();
    }


    public function getProjectsForOwners()
    {
        return Project::where('owner_id', Auth::user()->UserOwnerData->id)->get();
    }

    public function getProperties()
    {

        return Property::where('broker_id', Auth::user()->UserBrokerData->id)
        ->whereNull('project_id')
        ->get();
    }

    public function getPropertiesForOwners()
    {

        return Property::where('owner_id', Auth::user()->UserOwnerData->id)
        ->whereNull('project_id')
        ->get();
    }



}
