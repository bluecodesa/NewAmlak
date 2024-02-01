<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles =  Role::orderBy('id', 'DESC')->paginate(50);
        return view('Admin.roles.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('Admin.roles.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $permissions = Permission::whereIn('id', $request->permission)->get();
        $role = Role::create(['name' => $request->name]);
        $role->update($request->all());
        $role->syncPermissions($permissions);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        $role_permissions =  $role->permissions->pluck('id')->toArray();;

        return view('Admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'role_permissions' => $role_permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $permissions = Permission::whereIn('id', $request->permission)->get();
        $role->update($request->except('permission'));
        $role->syncPermissions($permissions);
        $users = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role->name);
        })->get();

        foreach ($users as $user) {
            $user->syncRoles([$role->name]);

            // Sync permissions directly from the role
            $user->syncPermissions($permissions);
        }

        return redirect()->route('Admin.roles.index')->withSuccess(__('Update successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name == 'App_SuperAdmin') {
            abort(403, __('SUPER ADMIN ROLE CAN NOT BE DELETED'));
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, __('CAN NOT DELETE SELF ASSIGNED ROLE'));
        }
        $role->delete();
        return redirect()->route('roles.index')
            ->withSuccess(__('Role is deleted successfully.'));
    }
}