<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
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
        $permissions =  Permission::orderBy('id', 'DESC')->paginate(100);
        return view('Admin.roles.permissions.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $models = Permission::distinct()->pluck('model')->toArray();
        return view('Admin.roles.permissions.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        $rules = ['name' => ['required', Rule::unique('permissions', 'name')]];
        $rules += [
            'name_ar' => 'required|string|max:255',
            'section_id' => 'required', // Update to expect 'section_id' instead of 'model'
            'is_admin' => 'required_if:is_user,0',
        ];
        $request->validate($rules);
        Permission::create($request->all());
        return redirect()->route('Admin.Permissions.index')
            ->withSuccess(__('New Permission is added successfully'));
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
    public function edit(Permission $Permission)
    {
        $sections = Section::all();
        return view('Admin.roles.permissions.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $Permission): RedirectResponse
    {

        $rules = [];
        $rules = [
            'name' => [
                'required',
                Rule::unique('permissions')->ignore($Permission->id),
                'max:25',
            ]
        ];
        $request->validate($rules);
        $Permission->update($request->all());
        return redirect()->route('Admin.Permissions.index')
            ->withSuccess(__('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $Permission): RedirectResponse
    {
        $Permission->delete();
        return redirect()->route('Admin.Permissions.index')
            ->withSuccess(__('deleted successfully'));
    }
}
