<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SectionRepositoryInterface;
use Illuminate\Validation\Rule;

class SectionService
{
    protected $SectionRepository;

    public function __construct(SectionRepositoryInterface $SectionRepository)
    {
        $this->SectionRepository = $SectionRepository;
    }

    public function getAll()
    {
        return $this->SectionRepository->getAll();
    }

    function getById($id)
    {
        return $this->SectionRepository->getById($id);
    }

    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('section_translations', 'name')],
                $locale . '.description' => 'nullable|string' // Add validation rule for description
            ];
        }
        validator($data, $rules)->validate();
        return $this->SectionRepository->create($data);
    }




    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('section_translations', 'name')->ignore($id, 'section_id')],
                $locale . '.description' => 'nullable|string' // Add validation rule for description

            ];
        }
        validator($data, $rules)->validate();
        return $this->SectionRepository->update($id, $data);
    }



    public function delete($id)
    {
        return $this->SectionRepository->delete($id);
    }
}
