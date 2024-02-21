<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PropertyUsageRepository;
use Illuminate\Validation\Rule;

class PropertyUsageService
{
    protected $PropertyUsageRepository;

    public function __construct(PropertyUsageRepository $PropertyUsageRepository)
    {
        $this->PropertyUsageRepository = $PropertyUsageRepository;
    }

    public function getAll()
    {
        return $this->PropertyUsageRepository->getAll();
    }

    function getById($id)
    {
        return $this->PropertyUsageRepository->getById($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_usage_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        return $this->PropertyUsageRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_usage_translations', 'name')->ignore($id, 'property_usage_id')]];
        }
        validator($data, $rules)->validate();
        return $this->PropertyUsageRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->PropertyUsageRepository->delete($id);
    }
}