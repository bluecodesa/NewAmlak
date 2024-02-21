<?php

namespace App\Services\Admin;

use App\Repositories\Admin\DistrictRepository;
use Illuminate\Validation\Rule;

class DistrictService
{
    protected $DistrictRepository;

    public function __construct(DistrictRepository $DistrictRepository)
    {
        $this->DistrictRepository = $DistrictRepository;
    }

    public function getAllDistrict()
    {
        return $this->DistrictRepository->getAllDistrict();
    }

    function getDistrictById($id)
    {
        return $this->DistrictRepository->getDistrictById($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('district_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        return $this->DistrictRepository->createDistrict($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('region_translations', 'name')->ignore($id, 'region_id')]];
        }
        validator($data, $rules)->validate();
        return $this->DistrictRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->DistrictRepository->delete($id);
    }
}
