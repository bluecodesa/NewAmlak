<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Models\Section;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getAll()
    {
        return Permission::orderBy('id', 'DESC')->paginate(100);
    }

    public function create($data)
    {
        return Section::create($data);
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
        return Section::find($id);
    }

    public function update($id, $data)
    {
        $Section = Section::findOrFail($id);
        $Section->update($data);
        return $Section;
    }

    public function delete($id)
    {
        return Section::findOrFail($id)->delete();
    }
}