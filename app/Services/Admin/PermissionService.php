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
            'name_ar' => 'required|string',
            'section_id' => 'required', // Update to expect 'section_id' instead of 'model'
            'is_admin' => 'required_if:is_user,0',
        ];

        $messages = [
            'name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            'name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
            'name_ar.required' => __('The :attribute field is required.', ['attribute' => __('Arabic name')]),
            'name_ar.string' => __('The :attribute must be a string.', ['attribute' => __('Arabic name')]),
            'section_id.required' => __('The :attribute field is required.', ['attribute' => __('section ID')]),
        ];
        
        validator($data, $rules, $messages)->validate();        
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
        $messages = [
            'name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
            'name.unique' => __('The :attribute has already been taken.', ['attribute' => __('name')]),
            'name_ar.required' => __('The :attribute field is required.', ['attribute' => __('Arabic name')]),
            'name_ar.string' => __('The :attribute must be a string.', ['attribute' => __('Arabic name')]),
            'section_id.required' => __('The :attribute field is required.', ['attribute' => __('section ID')]),
        ];
        
        validator($data, $rules, $messages)->validate();
        return $this->PermissionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->PermissionRepository->delete($id);
    }

    public function getRolePermissions($roleId){
        return $this->PermissionRepository->getRolePermissions($roleId);

    }
}
