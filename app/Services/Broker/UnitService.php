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
            'number_unit' => 'required|string',
            'city_id' => 'required',
            'location' => 'required',
            'property_type_id' => 'required',
            'property_usage_id' => 'required',
            'owner_id' => 'required',
            'instrument_number' => [
                'nullable',
                Rule::unique('units')->ignore($id),
                'max:25'
            ],
            'service_type_id' => 'required',
            "show_gallery" => 'nullable',
            'space' => 'required|numeric',
            'rooms' => 'required|numeric',
            'bathrooms' => 'required|numeric',
            'show_gallery' => 'nullable',
            'price' => 'required|numeric',
            'type' => ['required', Rule::in(['sale', 'rent'])],
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id', // Assuming your services table name is 'services'
            'name' => 'required|array',
            'name.*' => 'string',
            'qty' => 'required|array',
            'qty.*' => 'string',
        ];

        // Validate data
        validator($data, $rules)->validate();

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
