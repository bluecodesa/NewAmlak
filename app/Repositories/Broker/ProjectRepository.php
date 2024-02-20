<?php

namespace App\Repositories\Broker;

use App\Models\Project;
use App\Models\Property;

class ProjectRepository
{
    public function getAllByBrokerId($brokerId)
    {
        return Project::where('broker_id', $brokerId)->get();
    }

    public function create($data)
    {
        return Project::create($data);
    }

    public function update($id, $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }


    function ShowProject($id)
    {
        return Project::find($id);
    }

    public function delete($id)
    {
        return Project::destroy($id);
    }

    public function storeProperty($data)
    {
        return Property::create($data);
    }
}
