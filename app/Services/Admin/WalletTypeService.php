<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\WalletTypeRepositoryInterface;
use Illuminate\Validation\Rule;

class WalletTypeService
{
    protected $WalletRepository;

    public function __construct(WalletTypeRepositoryInterface $WalletRepository)
    {
        $this->WalletRepository = $WalletRepository;
    }

    public function getAll()
    {
        return $this->WalletRepository->getAll();
    }

    function getById($id)
    {
        return $this->WalletRepository->getById($id);
    }

    public function create($data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('wallet_type_translations', 'name')],
            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->WalletRepository->create($data);
    }




    public function update($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => ['required', Rule::unique('wallet_type_translations', 'name')->ignore($id, 'wallet_type_id')],

            ];
        }
        $messages = [
            '*.name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            '*.name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
        ];

        validator($data, $rules, $messages)->validate();
        return $this->WalletRepository->update($id, $data);
    }



    public function delete($id)
    {
        return $this->WalletRepository->delete($id);
    }
}
