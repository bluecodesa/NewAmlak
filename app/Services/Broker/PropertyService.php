<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\PropertyRepositoryInterface;
use App\Models\Broker;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\UniqueAcrossTables;


class PropertyService
{

    protected $PropertyRepository;

    public function __construct(PropertyRepositoryInterface $PropertyRepository)
    {
        $this->PropertyRepository = $PropertyRepository;
    }

    public function getAll($brokerId)
    {
        return $this->PropertyRepository->getAll($brokerId);
    }

    public function store($data, $images)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'service_type_id' => 'required|exists:service_types,id',
            'is_divided' => 'required|boolean',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties'),
                'max:25'
            ],
            // 'ad_license_number' => [
            //     'required',
            //     new UniqueAcrossTables('ad_license_number'), // Custom rule to check uniqueness across tables
            //     'max:25'
            //     ],
        ];

        // Validate data
        $messages = [
            'name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            'name.string' => __('The :attribute must be a string.', ['attribute' => __('name')]),
            'name.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('name'), 'max' => 255]),
            'location.required' => __('The :attribute field is required.', ['attribute' => __('location')]),
            'location.string' => __('The :attribute must be a string.', ['attribute' => __('location')]),
            'location.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('location'), 'max' => 255]),
            'service_type_id.required' => __('The :attribute field is required.', ['attribute' => __('service type')]),
            'service_type_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('service type')]),
            'is_divided.required' => __('The :attribute field is required.', ['attribute' => __('is divided')]),
            'is_divided.boolean' => __('The :attribute field must be true or false.', ['attribute' => __('is divided')]),
            'city_id.required' => __('The :attribute field is required.', ['attribute' => __('city')]),
            'city_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('city')]),
            'owner_id.required' => __('The :attribute field is required.', ['attribute' => __('owner')]),
            'owner_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('owner')]),
            'instrument_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('instrument number')]),
            'instrument_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('instrument number'), 'max' => 25]),
            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),

        ];

        validator($data, $rules, $messages)->validate();

        $data['broker_id'] = Auth::user()->UserBrokerData->id;

        $Property = $this->PropertyRepository->store($data, $images);

        return $Property;
    }

    public function findById($id)
    {
        return $this->PropertyRepository->findById($id);
    }

    public function update($id, $data, $images)
    {

        // Update project
        $project = $this->PropertyRepository->update($id, $data, $images);

        return $project;
    }


    public function delete($id)
    {
        return $this->PropertyRepository->delete($id);
    }

    function autocomplete($data)
    {
        return $this->PropertyRepository->autocomplete($data);
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
                Rule::unique('units')->ignore($id),
                'max:25'
            ],
            'service_type_id' => 'required',
            "show_in_gallery" => 'sometimes',
            'type' => ['required', Rule::in(['sale', 'rent', 'rent and sale'])],
            'ad_license_number' => [
                'required',
                new UniqueAcrossTables('ad_license_number'), // Custom rule to check uniqueness across tables
                'max:25'
                ],

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

            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),


        ];

        // Validate data
        validator($data, $rules, $messages)->validate();

        $unit = $this->PropertyRepository->StoreUnit($id, $data);

        return $unit;
    }

    function ShowPublicProject($id)
    {
        return   $this->PropertyRepository->ShowPublicProperty($id);
    }
}
