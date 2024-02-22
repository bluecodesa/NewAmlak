<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use Illuminate\Validation\Rule;

class RoleService
{
    protected $RoleRepository;

    public function __construct(RoleRepositoryInterface $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    public function getAll()
    {
        return $this->RoleRepository->getAll();
    }

    function getById($id)
    {
        return $this->RoleRepository->getById($id);
    }

    function ShowById($id)
    {
        return $this->RoleRepository->ShowById($id);
    }

    public function create($data)
    {
        $rules = [
            'name' => 'required|string|max:250|unique:roles,name',
            'permission' => 'required',
        ];
        validator($data, $rules)->validate();
        return $this->RoleRepository->create($data);
    }

    public function update($id, $data)
    {
        $rules = [];
        $rules += [
            'name_ar' => 'required|string|max:255',
            'section_id' => 'required', // Update to expect 'section_id' instead of 'model'
            'is_admin' => 'required_if:is_user,0',
        ];
        $rules = [
            'name' => [
                'required',
                Rule::unique('permissions')->ignore($id),
                'max:25',
            ]
        ];
        validator($data, $rules)->validate();
        return $this->RoleRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->RoleRepository->delete($id);
    }
}
