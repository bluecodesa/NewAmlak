<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class UnitService
{

    protected $UnitRepository;


    public function __construct(UnitRepositoryInterface $UnitRepository)
    {
        $this->UnitRepository = $UnitRepository;
    }

    public function getAll($brokerId)
    {
        return $this->UnitRepository->getAll($brokerId);
    }

    public function store($data)
    {
        $rules = [
            // 'number_unit' => 'required',
            // 'city_id' => 'required',
            // 'location' => 'required',
            // 'property_type_id' => 'required',
            // 'property_usage_id' => 'required',
            // 'owner_id' => 'required',
            // 'instrument_number' => 'nullable',
            'instrument_number' => [
                'nullable',
                Rule::unique('units'),
                'max:25'
            ],
            // 'service_type_id' => 'required',
            // "show_gallery" => 'required',
            // 'space' => 'required|numeric',
            // 'rooms' => 'required|numeric',
            // 'bathrooms' => 'required|numeric',
            // 'show_gallery' => 'nullable',
            // 'price' => 'required|numeric',
            // 'type' => ['required', Rule::in(['sale', 'rent'])],
            // 'service_id' => 'required|array',
            // 'service_id.*' => 'exists:services,id', // Assuming your services table name is 'services'
            // 'name' => 'required|array',
            // 'name.*' => 'string',
            // 'qty' => 'required|array',
            // 'qty.*' => 'string',
        ];

        // Validate data
        validator($data, $rules)->validate();

        $unit = $this->UnitRepository->store($data);

        return $unit;
    }

    public function findById($id)
    {
        return $this->UnitRepository->findById($id);
    }

    public function update($id, $data)
    {
        // Validation rules
        $rules = [
            'instrument_number' => [
                'nullable',
                Rule::unique('units')->ignore($id),
                'max:25'
            ],
            'price' => 'digits_between:0,10',
            'service_type_id' => 'required',
            "show_gallery" => 'sometimes',
            'type' => ['required', Rule::in(['sale', 'rent', 'rent and sale'])],
            // 'name' => 'required|array',
            // 'qty' => 'required|array',

            'monthly' => 'digits_between:0,8',
            'daily' => 'digits_between:0,8',
            'quarterly' => 'digits_between:0,8',
            'midterm' => 'digits_between:0,10',
            'yearly' => 'digits_between:0,10',

        ];
        $messages = [
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'service_type_id.required' => 'The service type field is required.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid.',
            // 'name.required' => 'The name field is required.',
            // 'qty.required' => 'The quantity field is required.',
            'price' => 'price must be smaller than or equal to 10 numbers.',
            'monthly' => 'Monthly price must be smaller than or equal to 8.',
            'daily' => 'daily price must be smaller than or equal to 8.',
            'quarterly' => 'quarterly price must be smaller than or equal to 8.',
            'midterm' => 'midterm price must be smaller than or equal to 10.',
            'yearly' => 'yearly price must be smaller than or equal to 10.',

        ];

        // Validate data
        validator($data, $rules, $messages)->validate();

        $unit = $this->UnitRepository->update($id, $data);

        return $unit;
    }


    public function delete($id)
    {
        return $this->UnitRepository->delete($id);
    }

    public function countUnitsForBroker($brokerId)
    {
        // Instantiate the model

        $residentialCount = Unit::where('broker_id', $brokerId)
            ->whereHas('PropertyUsageData.translations', function ($query) {
                $query->where('name', 'Residential');
            })
            ->count();

        $nonResidentialCount =  Unit::where('broker_id', $brokerId)
            ->whereDoesntHave('PropertyUsageData.translations', function ($query) {
                $query->where('name', 'Residential');
            })
            ->count();

        return [
            'residential' => $residentialCount,
            'non_residential' => $nonResidentialCount,
        ];
    }
}
