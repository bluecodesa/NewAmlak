<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\ProviderServiceRepositoryInterface;
use Illuminate\Validation\Rule;

class ProviderServiceService
{
    protected $ProviderServiceRepository;

    public function __construct(ProviderServiceRepositoryInterface $ProviderServiceRepository)
    {
        $this->ProviderServiceRepository = $ProviderServiceRepository;
    }

    public function getAll()
    {
        return $this->ProviderServiceRepository->getAll();
    }

    function getById($id)
    {
        return $this->ProviderServiceRepository->getById($id);
    }

    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('provider_service_translations', 'name')],
            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->ProviderServiceRepository->create($data);
    }




    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('provider_service_translations', 'name')->ignore($id, 'provider_service_id')],

            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->ProviderServiceRepository->update($id, $data);
    }



    public function delete($id)
    {
        return $this->ProviderServiceRepository->delete($id);
    }
}
