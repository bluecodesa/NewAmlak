<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function getAllRoles()
    {
        return Role::where('type', 'user')->get();
    }
    function getById($id)
    {
        return Role::find($id);
    }
}
