<?php
// app/Services/DeveloperService.php

namespace App\Services\Broker;

use App\Models\Developer;
use App\Models\User;
use App\Repositories\Broker\DeveloperRepository;
use App\Interfaces\Broker\DeveloperRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeveloperService
{
    protected $developerRepository;

    public function __construct(DeveloperRepositoryInterface $developerRepository)
    {
        $this->developerRepository = $developerRepository;
    }

    public function getAllDevelopersById($brokerId)
    {
        return $this->developerRepository->getAllByBrokerId($brokerId);
    }

    public function getDeveloperById($id)
    {
        return $this->developerRepository->find($id);
    }

    public function createDeveloper($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers'),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('developers'),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();

        $data['broker_id'] = Auth::user()->UserBrokerData->id;
        $developer = $this->developerRepository->create($data);

        // Sending notification to admins
        $ids = User::where('is_admin', 1)->pluck('id')->toArray();
        $notificationData = [
            'title' => __('Add New Developer'),
            'url' => route('Admin.Developer.index'),
            'body' => __('A developer has been added to the system account') . ' : ' . (Auth::user()->name),
        ];
        $this->sendNotification($notificationData, $ids);

        return $developer;
    }

    public function updateDeveloper($id, $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers')->ignore($id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('developers')->ignore($id),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();

        $developer = $this->developerRepository->update($id, $data);

        return $developer;
    }

    public function deleteDeveloper($id)
    {
        return $this->developerRepository->delete($id);
    }

    protected function sendNotification($data, $ids)
    {
        // Implement notification sending logic here
    }
}
