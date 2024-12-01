<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\PropertyTypeRepositoryInterface;
use App\Repositories\Admin\PropertyTypeRepository;
use Illuminate\Validation\Rule;

class PropertyTypeService
{
    protected $PropertyTypeRepository;

    public function __construct(PropertyTypeRepositoryInterface $PropertyTypeRepository)
    {
        $this->PropertyTypeRepository = $PropertyTypeRepository;
    }

    public function getAll()
    {
        return $this->PropertyTypeRepository->getAll();
    }

    function getById($id)
    {
        return $this->PropertyTypeRepository->getById($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_type_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->PropertyTypeRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('property_type_translations', 'name')->ignore($id, 'property_type_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->PropertyTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->PropertyTypeRepository->delete($id);
    }
}
