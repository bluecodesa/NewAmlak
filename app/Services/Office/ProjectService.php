<?php
// app/Services/ProjectService.php

namespace App\Services\Office;

use App\Interfaces\Office\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjectsByOfficeId($officeId)
    {
        return $this->projectRepository->getAllByOfficeId($officeId);
    }

    public function createProject($data, $files)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'project_masterplan' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'project_brochure' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            // 'ad_license_number' => [
            //     'required',
            //     new UniqueAcrossTables('ad_license_number'), // Custom rule to check uniqueness across tables
            //     'max:25'
            //     ],

        ];
        $messages = [
            'name.required' => __('The project name is required.'),
            'name.string' => __('The project name must be a string.'),
            'name.max' => __('The project name may not be greater than :max characters.', ['max' => 255]),

            'location.required' => __('The location is required.'),
            'location.string' => __('The location must be a string.'),
            'location.max' => __('The location may not be greater than :max characters.', ['max' => 255]),

            'city_id.required' => __('The city is required.'),
            'city_id.exists' => __('The selected city is invalid.'),

            'project_masterplan.file' => __('The project masterplan must be a file.'),
            'project_masterplan.mimes' => __('The project masterplan must be a file of type: jpeg, png, jpg, gif, pdf.'),
            'project_masterplan.max' => __('The project masterplan may not be greater than :max kilobytes.', ['max' => 2048]),

            'project_brochure.file' => __('The project brochure must be a file.'),
            'project_brochure.mimes' => __('The project brochure must be a file of type: jpeg, png, jpg, gif, pdf.'),
            'project_brochure.max' => __('The project brochure may not be greater than :max kilobytes.', ['max' => 2048]),


            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),



        ];

        // Validate data
        validator($data, $rules ,$messages)->validate();

        $data['office_id'] = Auth::user()->UserOfficeData->id;

        // Create project
        return $this->projectRepository->create($data, $files);
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
            // 'ad_license_number' => [
            //     'required',
            //     Rule::unique('projects')->ignore($id),
            //     'max:25'
            // ],
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
            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),


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
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'city_id' => 'required|exists:cities,id',
        //     'property_type_id' => 'required|exists:property_types,id',
        //     'property_usage_id' => 'required|exists:property_usages,id',
        //     'employee_id' => 'required|exists:employees,id',
        //     'owner_id' => 'required|exists:owners,id',
        // ];

        // // Validate data
        // validator($data, $rules)->validate();
        $data['office_id'] = Auth::user()->UserOfficeData->id;
        $data['project_id'] = $projectId;
        $property = $this->projectRepository->storeProperty($data, $images);

        return $property;
    }

    function StoreUnit($id, $data)
    {
        $rules = [
            'number_unit' => 'required|string',
            'city_id' => 'required',
            'location' => 'required',
            'property_type_id' => 'required',
            'property_usage_id' => 'required',
            'owner_id' => 'required',
            'price' => 'digits_between:0,10',
            'monthly' => 'digits_between:0,8',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties')->ignore($id),
                'max:25'
            ],
            'service_type_id' => 'required',
            "show_in_gallery" => 'sometimes',
            'type' => ['required', Rule::in(['sale', 'rent','rent and sale'])],

        ];
        $messages = [
            'number_unit.required' => 'The number unit field is required.',
            'city_id.required' => 'The city field is required.',
            'location.required' => 'The location field is required.',
            'property_type_id.required' => 'The property type field is required.',
            'property_usage_id.required' => 'The property usage field is required.',
            'owner_id.required' => 'The owner field is required.',
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'service_type_id.required' => 'The service type field is required.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid.',
            'price' => 'price must be smaller than or equal to 10 numbers.',
            'monthly' => 'Monthly price must be smaller than or equal to 8.',
        ];

        // Validate data
        validator($data, $rules,$messages)->validate();

        $unit = $this->projectRepository->StoreUnit($id, $data);

        return $unit;
    }
    function autocomplete($data)
    {
        return $this->projectRepository->autocomplete($data);
    }
}
