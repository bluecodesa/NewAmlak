<?php

namespace App\Services\Broker;

use App\Repositories\Broker\AdvisorRepository;
use App\Interfaces\Broker\AdvisorRepositoryInterface;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdvisorService
{
    protected $advisorRepository;

    public function __construct(AdvisorRepository $advisorRepository)
    {
        $this->advisorRepository = $advisorRepository;
    }

    public function getAllAdvisorsForBroker()
    {
        return $this->advisorRepository->getAllAdvisorsForBroker(Auth::user()->UserBrokerData->id);
    }

    function getAdvisorById($id)
    {
        return $this->advisorRepository->getAdvisorById($id);
    }

    public function createAdvisor($data)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('advisors'),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('advisors'),
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
            'phone.required' => 'The phone field is required.',
            'phone.unique' => 'The phone has already been taken.',
            'phone.max' => 'The phone may not be greater than :max characters.',
        ];

        validator($data, $rules, $messages)->validate();
        
        $data['broker_id'] = Auth::user()->UserBrokerData->id;
        return $this->advisorRepository->createAdvisor($data);
    }

    public function updateAdvisor($id, $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('advisors')->ignore($id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('advisors')->ignore($id),
                'max:25'
            ],
        ];

        validator($data, $rules)->validate();
        return $this->advisorRepository->updateAdvisor($id, $data);
    }

    public function deleteAdvisor($id)
    {
        return $this->advisorRepository->deleteAdvisor($id);
    }
}
