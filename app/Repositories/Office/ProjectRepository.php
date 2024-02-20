<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Office;

use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Models\Project;
use App\Models\Property;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {
        return Project::where('office_id', $officeId)->get();
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