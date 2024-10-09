<?php

namespace App\Services\Office;

use App\Interfaces\Office\UnitRepositoryInterface;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class UnitService
{

    protected $UnitRepository;


    public function __construct(UnitRepositoryInterface $UnitRepository)
    {
        $this->UnitRepository = $UnitRepository;
    }

    public function getAll($officeId)
    {
        return $this->UnitRepository->getAll($officeId);
    }
    public function getAllByOffice($officeId)
    {
        return $this->UnitRepository->getAll($officeId);
    }

    public function store($data)
    {
        $rules = [
   
            'instrument_number' => [
                'nullable',
                Rule::unique('units'),
                'max:25'
            ],

        ];


        $messages = [


            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),


        ];

        // Validate data
        validator($data, $rules,$messages)->validate();

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
            'ad_license_number' => [
                'required',
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

            'ad_license_number.required' => __('The :attribute field is required.', ['attribute' => __('ad license number')]),
            'ad_license_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('ad license number')]),
            'ad_license_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('ad license number'), 'max' => 25]),



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

    public function countUnitsForOffice($officeId)
    {
        // Instantiate the model

        $residentialCount = Unit::where('office_id', $officeId)
            ->whereHas('PropertyUsageData.translations', function ($query) {
                $query->where('name', 'Residential');
            })
            ->count();

        $nonResidentialCount =  Unit::where('Office_id', $officeId)
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
