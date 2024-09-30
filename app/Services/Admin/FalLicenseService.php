<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\FalLicenseRepositoryInterface;
use App\Models\Fal;
use Illuminate\Validation\Rule;

class FalLicenseService
{
    protected $FalLicenseRepository;

    public function __construct(FalLicenseRepositoryInterface $FalLicenseRepository)
    {
        $this->FalLicenseRepository = $FalLicenseRepository;
    }

    public function getAll()
    {
        return $this->FalLicenseRepository->getAll();
    }

    function getById($id)
    {
        return $this->FalLicenseRepository->getById($id);
    }

    public function create($data)
    {
        $rules = [
            'for_gallery' => ['nullable', 'boolean'], 
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('fal_translations', 'name')],
            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();

        if (isset($data['for_gallery']) && $data['for_gallery'] == 1) {
            $existingForGallery = Fal::where('for_gallery', 1)->exists();
            
            if ($existingForGallery) {
                return redirect()->back()
                    ->withErrors(['for_gallery' => __('A License with "for_gallery = 1" already exists. You cannot add another.')])
                    ->withInput();
            }
        }
    

        return $this->FalLicenseRepository->create($data);
    }




    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('fal_translations', 'name')->ignore($id, 'fal_id')],
                $locale . '.description' => 'nullable|string' // Add validation rule for description

            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
            '*.description.string' => __('The :attribute must be a string.', ['attribute' => __('description')])
        ];

        validator($data, $rules, $messages)->validate();
        return $this->FalLicenseRepository->update($id, $data);
    }



    public function delete($id)
    {
        return $this->FalLicenseRepository->delete($id);
    }
}
