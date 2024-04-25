<?php

namespace App\Services\Broker;

use App\Models\Project;
use App\Models\PropertyImage;
use App\Models\User;
use App\Repositories\Broker\ProjectRepository;
use App\Interfaces\Broker\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjectsByBrokerId($brokerId)
    {
        return $this->projectRepository->getAllByBrokerId($brokerId);
    }

    public function createProject($data, $images)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            // 'developer_id' => 'required|exists:developers,id',
            // 'advisor_id' => 'required|exists:advisors,id',
            // 'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        validator($data, $rules)->validate();

        $data['broker_id'] = Auth::user()->UserBrokerData->id;

        // Create project
        $project = $this->projectRepository->create($data, $images);

        return $project;
    }

    public function findProjectById($id)
    {
        return $this->projectRepository->ShowProject($id);
    }

    public function updateProject($id, $data, $images)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            // 'developer_id' => 'required|exists:developers,id',
            // 'advisor_id' => 'required|exists:advisors,id',
            // 'owner_id' => 'required|exists:owners,id',
        ];

        // Validate data
        $messages = [
            'name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            'name.string' => __('The :attribute must be a string.', ['attribute' => __('name')]),
            'name.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('name'), 'max' => 255]),
            'location.required' => __('The :attribute field is required.', ['attribute' => __('location')]),
            'location.string' => __('The :attribute must be a string.', ['attribute' => __('location')]),
            'location.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('location'), 'max' => 255]),
            'city_id.required' => __('The :attribute field is required.', ['attribute' => __('city')]),
            'city_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('city')]),
       ];
        
        validator($data, $rules, $messages)->validate();
        
        // Update project
        $project = $this->projectRepository->update($id, $data, $images);

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

        $data['broker_id'] = Auth::user()->UserBrokerData->id;
        $data['project_id'] = $projectId;
        $property = $this->projectRepository->storeProperty($data, $projectId, $images);
        return $property;
    }
}
