<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\TicketTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class TicketTypeService
{
    protected $ticketTypeRepository;

    public function __construct(TicketTypeRepositoryInterface $ticketTypeRepository)
    {
        $this->ticketTypeRepository = $ticketTypeRepository;
    }

    public function getAllTicketTypes()
    {
        return $this->ticketTypeRepository->all();
    }

    public function createTicketType(array $data)
    {
        // You can add validation logic here if needed
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ticketTypeRepository->create($data);
    }

    public function findTicketType(int $id)
    {
        return $this->ticketTypeRepository->find($id);
    }

    public function updateTicketType(array $data, int $id)
    {
        // You can add validation logic here if needed
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')->ignore($id, 'ticket_type_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ticketTypeRepository->update($data, $id);
    }

    public function deleteTicketType(int $id)
    {
        return $this->ticketTypeRepository->delete($id);
    }
}
