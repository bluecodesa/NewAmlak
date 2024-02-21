<?php

namespace App\Services\Admin;

use App\Repositories\Admin\CityRepository;
use Illuminate\Validation\Rule;

class CityService
{
    protected $CityRepository;

    public function __construct(CityRepository $CityRepository)
    {
        $this->CityRepository = $CityRepository;
    }

    public function getAllCities()
    {
        return $this->CityRepository->getAllCities();
    }

    function getCityById($id)
    {
        return $this->CityRepository->getCityById($id);
    }

    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('city_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        return $this->CityRepository->createCity($data);
    }

    public function updateCity($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('city_translations', 'name')->ignore($id, 'city_id')]];
        }

        validator($data, $rules)->validate();
        return $this->CityRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->CityRepository->delete($id);
    }
}
