<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\PermissionRepositoryInterface;
use Illuminate\Validation\Rule;

class PermissionService
{
    protected $PermissionRepository;

    public function __construct(PermissionRepositoryInterface $PermissionRepository)
    {
        $this->PermissionRepository = $PermissionRepository;
    }

    public function getAll()
    {
        return $this->PermissionRepository->getAll();
    }

    function getById($id)
    {
        return $this->PermissionRepository->getById($id);
    }

    function ShowById($id)
    {
        return $this->PermissionRepository->ShowById($id);
    }

    public function create($data)
    {
        $rules = [];
        $rules = ['name' => ['required', Rule::unique('permissions', 'name')]];
        $rules += [
            'name_ar' => 'required|string|max:255',
            'section_id' => 'required', // Update to expect 'section_id' instead of 'model'
            'is_admin' => 'required_if:is_user,0',
        ];

        validator($data, $rules)->validate();
        return $this->PermissionRepository->create($data);
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
        return $this->PermissionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->PermissionRepository->delete($id);
    }
}
