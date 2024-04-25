<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\PropertyUsageRepositoryInterface;
use Illuminate\Validation\Rule;

class PropertyUsageService
{
    protected $PropertyUsageRepository;

    public function __construct(PropertyUsageRepositoryInterface $PropertyUsageRepository)
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
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->PropertyUsageRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_usage_translations', 'name')->ignore($id, 'property_usage_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->PropertyUsageRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->PropertyUsageRepository->delete($id);
    }
}