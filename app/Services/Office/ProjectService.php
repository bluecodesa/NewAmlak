<?php
// app/Services/ProjectService.php

namespace App\Services\Office;

use App\Models\Project;
use App\Models\PropertyImage;
use App\Models\User;
use App\Repositories\Office\ProjectRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjectsByOfficeId($officeId)
    {
        return $this->projectRepository->getAllByOfficeId($officeId);
    }

    public function createProject($data)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'developer_id' => 'required|exists:developers,id',
            'advisor_id' => 'required|exists:advisors,id',
            'employee_id' => 'required|exists:employees,id',
            'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();

        // Set office_id from logged in user
        $data['office_id'] = Auth::user()->UserOfficeData->id;

        // Create project
        $project = $this->projectRepository->create($data);

        return $project;
    }

    public function findProjectById($id)
    {
        return $this->projectRepository->ShowProject($id);
    }

    public function updateProject($id, $data)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'developer_id' => 'required|exists:developers,id',
            'advisor_id' => 'required|exists:advisors,id',
            'employee_id' => 'required|exists:employees,id',
            'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();

        // Update project
        $project = $this->projectRepository->update($id, $data);

        return $project;
    }

    function ShowProject($id)
    {
        return   $this->projectRepository->ShowProject($id);
    }

    public function deleteProject($id)
    {
        return $this->projectRepository->delete($id);
    }

    public function storeProperty($data, $projectId, $images)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'property_type_id' => 'required|exists:property_types,id',
            'property_usage_id' => 'required|exists:property_usages,id',
            'employee_id' => 'required|exists:employees,id',
            'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();
        $data['office_id'] = Auth::user()->UserOfficeData->id;
        $data['project_id'] = $projectId;
        $property = $this->projectRepository->storeProperty($data);
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
