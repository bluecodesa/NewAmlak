<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Office;

use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyImage;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {
        return Project::where('office_id', $officeId)->get();
    }

    public function create($data, $images)
    {
        if ($images) {
            $ext = $images->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $images->move(public_path('/Brokers/Projects/'), $imageName);
            $data['image'] = '/Brokers/Projects/' . $imageName;
        } else {
            $data['image'] = '/Brokers/Projects/default.svg';
        }
        return Project::create($data);
    }

    public function update($id, $data, $images)
    {
        $project = Project::findOrFail($id);
        if ($images) {
            $ext = $images->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $images->move(public_path('/Brokers/Projects/'), $imageName);
            $data['image'] = '/Brokers/Projects/' . $imageName;
        } else {
            $data['image'] = '/Brokers/Projects/default.svg';
        }
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

    public function storeProperty($data, $images)
    {
        $property =  Property::create($data);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Offices/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Offices/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        }
        return $property;
    }
}
