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

    public function __construct(DeveloperRepository $developerRepository)
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
            'full_phone' => [
                'required',
                Rule::unique('developers'),
                'max:25'
            ],
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'city_id.required' => 'The city field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.max' => 'The email may not be greater than :max characters.',
            'full_phone.required' => 'The phone field is required.',
            'full_phone.unique' => 'The phone has already been taken.',
            'full_phone.max' => 'The phone may not be greater than :max characters.',
        ];

        validator($data, $rules, $messages)->validate();

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
            'full_phone' => [
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
