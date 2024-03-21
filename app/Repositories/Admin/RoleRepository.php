<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::orderBy('id', 'DESC')->paginate(50);
    }

    public function create($data)
    {
        $permissions = Permission::whereIn('id', $data['permission'])->get();
        $role = Role::create(['name' => $data['name'], 'name_ar' => $data['name_ar']]);
        $role->syncPermissions($permissions);
        return $role;
    }
    function ShowById($id)
    {
        return  Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $id)
            ->select('name')
            ->get();
    }

    function getById($id)
    {
        return Role::find($id);
    }

    public function update($id, $data)
    {
        $role = Role::findOrFail($id);

        // Update the role's attributes
        $role->update($data);

        // Retrieve permissions based on the provided IDs
        $permissions = Permission::whereIn('id', $data['permission'])->get();

        // Update the role's permissions
        $role->syncPermissions($permissions);

        // Update users associated with this role
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role->name);
        })->get();


        // Sync the role for each user
        foreach ($users as $user) {
            $user->syncRoles([$role->name]);

            // Sync permissions directly from the role
            $user->syncPermissions($permissions);
        }

        return $role;
    }


    public function delete($id)
    {
        $role =  Role::findOrFail($id);
        if ($role->name == 'App_SuperAdmin') {
            abort(403, __('SUPER ADMIN ROLE CAN NOT BE DELETED'));
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, __('CAN NOT DELETE SELF ASSIGNED ROLE'));
        }
        try {
            $role->delete();
        } catch (\Throwable $th) {
            return back()->with('sorry', __('This role was not enabled because it was linked to a subscription'));
        }
    }
}
