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
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    protected $PermissionService;
    protected $RoleService;

    public function __construct(PermissionService $PermissionService, RoleService $RoleService)
    {
        // $this->middleware('auth');
        // $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        // $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        // $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-role', ['only' => ['destroy']]);
        $this->middleware(['can:read-role'])->only(['index']);
        $this->middleware(['can:create-role'])->only(['store', 'create']);
        $this->middleware(['can:update-role'])->only(['edit', 'update']);
        $this->middleware(['can:delete-role'])->only(['destroy']);
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

    public function update(Request $request, Role $role)
    {

        $roles = $request->name;

        $permissions = $request->permission;
        $rules = [];
        $rules = ['name' => [
            'required',
            Rule::unique('roles')->ignore($role->id),
            'max:25',
        ]];

        $request->validate($rules);
        $role->update($request->all());
        $permissions = Permission::whereIn('id', $request->permission)->get();
        $role->syncPermissions($permissions);

        $users =   User::whereHas('roles', function ($q) use ($roles) {
            $q->where('name', $roles);
        })->get();

        foreach ($users as $user) {
            $user->roles()->detach();
            $user->syncRoles($roles);
            $roles = Role::where('id', $role->id)->get();

            foreach ($roles as $perm) {
                $user->syncPermissions($perm->permissions);
            }
        }
        // $this->RoleService->update($id, $request->all());
        return redirect()->route('Admin.roles.index')->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->RoleService->delete($id);
        return redirect()->route('Admin.roles.index')
            ->withSuccess(__('Role is deleted successfully.'));
    }
}
