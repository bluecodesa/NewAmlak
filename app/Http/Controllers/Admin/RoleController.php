<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\PermissionService;
use App\Services\Admin\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    protected $PermissionService;
    protected $RoleService;

    public function __construct(PermissionService $PermissionService, RoleService $RoleService)
    {
        $this->middleware(['role_or_permission:read-role'])->only(['index']);
        $this->middleware(['role_or_permission:create-role'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-role'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-role'])->only(['destroy']);
        $this->PermissionService = $PermissionService;
        $this->RoleService = $RoleService;
    }

    public function index()
    {
        $roles =  $this->RoleService->getAll();
        return view('Admin.roles.index', get_defined_vars());
    }

    public function create()
    {
        $permissions = $this->PermissionService->getAll();
        return view('Admin.roles.create', get_defined_vars());
    }


    public function store(Request $request)
    {
        $this->RoleService->create($request->all());
        return redirect()->route('Admin.roles.index')
            ->withSuccess('New role is added successfully.');
    }
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $role->id)
            ->select('name')
            ->get();
        return view('Admin.roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function edit($id)
    {
        $role =   $this->RoleService->getById($id);
        $role_permissions =  $role->permissions->pluck('id')->toArray();;
        $permissions =  $this->PermissionService->getAll();
        return view('Admin.roles.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->RoleService->update($id, $request->all());
        return redirect()->route('Admin.roles.index')->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->RoleService->delete($id);
        return redirect()->route('Admin.roles.index')
            ->withSuccess(__('Role is deleted successfully.'));
    }
}
