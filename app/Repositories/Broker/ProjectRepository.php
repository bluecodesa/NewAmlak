<?php
// app/Repositories/ProjectRepository.php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\ProjectRepositoryInterface;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyImage;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByBrokerId($brokerId)
    {
        return Project::where('broker_id', $brokerId)->get();
    }

    public function create($data, $files)
    {
        // Handle image upload
        if (isset($files['image'])) {
            $image = $files['image'];
            $ext = $image->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $image->move(public_path('/Brokers/Projects/'), $imageName);
            $data['image'] = '/Brokers/Projects/' . $imageName;
        } else {
            $data['image'] = '/Brokers/Projects/default.svg';
        }

        // Handle project_masterplan upload
        if (isset($files['project_masterplan'])) {
            $projectMasterplan = $files['project_masterplan'];
            $ext = $projectMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $projectMasterplan->move(public_path('/Brokers/Projects/pdfs'), $masterplanName);
            $data['project_masterplan'] = '/Brokers/Projects/pdfs/' . $masterplanName;
        }

        // Handle project_brochure upload
        if (isset($files['project_brochure'])) {
            $projectBrochure = $files['project_brochure'];
            $ext = $projectBrochure->getClientOriginalExtension();
            $brochureName = uniqid() . '.' . $ext;
            $projectBrochure->move(public_path('/Brokers/Projects/pdfs'), $brochureName);
            $data['project_brochure'] = '/Brokers/Projects/pdfs/' . $brochureName;
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
            // } else {
            // $data['image'] = '/Brokers/Projects/default.svg';
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

    public function storeProperty($data, $id, $images)
    {
        $property =  Property::create($data);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() .  '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' =>  '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        }
        return $property;
    }
}
