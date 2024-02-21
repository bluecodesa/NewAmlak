<?php

namespace App\Services\Broker;

use App\Models\Project;
use App\Models\PropertyImage;
use App\Models\User;
use App\Repositories\Broker\ProjectRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjectsByBrokerId($brokerId)
    {
        return $this->projectRepository->getAllByBrokerId($brokerId);
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
            'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();

        $data['broker_id'] = Auth::user()->UserBrokerData->id;

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
            'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();
        $data['broker_id'] = Auth::user()->UserBrokerData->id;
        $data['project_id'] = $projectId;
        $property = $this->projectRepository->storeProperty($data);
        if ($images) {
            foreach ($images as $image) {
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        }

        return $property;
    }
}
