<?php

namespace App\Services\Office;

use App\Repositories\Office\AdvisorRepository;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdvisorService
{
    protected $advisorRepository;

    public function __construct(AdvisorRepository $advisorRepository)
    {
        $this->advisorRepository = $advisorRepository;
    }

    public function getAllAdvisorsForOffice()
    {
        return $this->advisorRepository->getAllAdvisorsForOffice(Auth::user()->UserOfficeData->id);
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

        validator($data, $rules)->validate();
        $data['office_id'] = Auth::user()->UserOfficeData->id;
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
