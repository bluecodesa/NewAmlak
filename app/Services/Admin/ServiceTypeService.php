<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\ServiceTypeRepositoryInterface;
use Illuminate\Validation\Rule;

class ServiceTypeService
{
    protected $ServiceTypeRepository;

    public function __construct(ServiceTypeRepositoryInterface $ServiceTypeRepository)
    {
        $this->ServiceTypeRepository = $ServiceTypeRepository;
    }

    public function getAll()
    {
        return $this->ServiceTypeRepository->getAll();
    }

    function getById($id)
    {
        return $this->ServiceTypeRepository->getById($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('service_type_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        return $this->ServiceTypeRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('service_type_translations', 'name')->ignore($id, 'service_type_id')]];
        }
        validator($data, $rules)->validate();
        return $this->ServiceTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->ServiceTypeRepository->delete($id);
    }
}
