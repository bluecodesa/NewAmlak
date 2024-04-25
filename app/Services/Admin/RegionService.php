<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\RegionRepositoryInterface;
use App\Repositories\Admin\RegionRepository;
use Illuminate\Validation\Rule;

class RegionService
{
    protected $RegionRepository;

    public function __construct(RegionRepositoryInterface $RegionRepository)
    {
        $this->RegionRepository = $RegionRepository;
    }

    public function getAllRegions()
    {
        return $this->RegionRepository->getAllRegions();
    }

    function getRegionById($id)
    {
        return $this->RegionRepository->getRegionById($id);
    }


    function getCityByRegionId($id)
    {
        return $this->RegionRepository->getCityByRegionId($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('region_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->RegionRepository->createRegion($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('region_translations', 'name')->ignore($id, 'region_id')]];
        }

        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->RegionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->RegionRepository->delete($id);
    }
}
