<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\InterestTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class InterestTypeService
{
    protected $interestTypeRepository;

    public function __construct(InterestTypeRepositoryInterface $interestTypeRepository)
    {
        $this->interestTypeRepository = $interestTypeRepository;
    }

    public function getAllInterestTypes()
    {
        return $this->interestTypeRepository->getAllInterestTypes();
    }

    function getInterestTypeById($id)
    {
        return $this->interestTypeRepository->getInterestTypeById($id);
    }

    public function createInterestType($data)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('interest_type_translations', 'name')]];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->interestTypeRepository->createInterestType($data);
    }

    public function updateInterestType($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('interest_type_translations', 'name')->ignore($id, 'interest_type_id')]];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->interestTypeRepository->updateInterestType($id, $data);
    }

    public function deleteInterestType($id)
    {
        return $this->interestTypeRepository->deleteInterestType($id);
    }
}
