<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\ServiceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceService
{
    protected $ServiceRepository;

    public function __construct(ServiceRepositoryInterface $ServiceRepository)
    {
        $this->ServiceRepository = $ServiceRepository;
    }

    public function getAll()
    {
        return $this->ServiceRepository->getAll();
    }

    function getById($id)
    {
        return $this->ServiceRepository->getById($id);
    }


    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('service_type_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        $data['created_by'] = Auth::id();
        return $this->ServiceRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('service_type_translations', 'name')->ignore($id, 'service_type_id')]];
        }
        validator($data, $rules)->validate();
        return $this->ServiceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->ServiceRepository->delete($id);
    }
}