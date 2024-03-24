<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\PropertyRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        ];

        // Validate data
        validator($data, $rules)->validate();

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
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'service_type_id' => 'required|exists:service_types,id',
            // 'is_divided' => 'required|boolean',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties')->ignore($id),
                'max:25'
            ],
        ];

        // Validate data
        validator($data, $rules)->validate();

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
            'instrument_number' => [
                'nullable',
                Rule::unique('properties')->ignore($id),
                'max:25'
            ],
            'service_type_id' => 'required',
            "show_gallery" => 'sometimes',
            // 'space' => 'sometimes|numeric',
            // 'rooms' => 'sometimes|numeric',
            // 'bathrooms' => 'sometimes|numeric',
            'show_gallery' => 'nullable',
            // 'price' => 'required|numeric',
            'type' => ['required', Rule::in(['sale', 'rent'])],
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id', // Assuming your services table name is 'services'
            'name' => 'required|array',
            // 'name.*' => 'string',
            'qty' => 'required|array',
            // 'qty.*' => 'integer|min:0',
        ];

        // Validate data
        validator($data, $rules)->validate();

        $unit = $this->PropertyRepository->StoreUnit($id, $data);

        return $unit;
    }
}
