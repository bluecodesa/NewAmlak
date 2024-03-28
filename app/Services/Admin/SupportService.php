<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SupportRepositoryInterface;
use Illuminate\Validation\Rule;

class SupportService
{
    protected $SupportRepository;

    public function __construct(SupportRepositoryInterface $SupportRepository)
    {
        $this->SupportRepository = $SupportRepository;
    }

    public function getAll()
    {
        return $this->SupportRepository->getAll();
    }

    function getById($id)
    {
        return $this->SupportRepository->getById($id);
    }

    public function create($data)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')]];
        }
        validator($data, $rules)->validate();
        return $this->SupportRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')->ignore($id, 'ticket_type_id')]];
        }
        validator($data, $rules)->validate();
        return $this->SupportRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->SupportRepository->delete($id);
    }

    
}
