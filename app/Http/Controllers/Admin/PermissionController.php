<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use App\Services\Admin\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $PermissionService;
    protected $SectionService;

    public function __construct(PermissionService $PermissionService, SectionService $SectionService)
    {
        $this->middleware(['role_or_permission:read-permission'])->only(['index']);
        $this->middleware(['role_or_permission:create-permission'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-permission'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-permission'])->only(['destroy']);
        $this->PermissionService = $PermissionService;
        $this->SectionService = $SectionService;
    }

    public function index()
    {
        // $role =  Auth::user()->roles[0];
        $permissions =  $this->PermissionService->getAll();
        // $role->givePermissionTo($permissions);
        return view('Admin.roles.permissions.index', get_defined_vars());
    }

    public function create()
    {
        $sections = $this->SectionService->getAll();
        $permissionsAll =  $this->PermissionService->getAll();
        $models = $permissionsAll->pluck('model')->unique()->toArray();
        return view('Admin.roles.permissions.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->PermissionService->create($request->all());
        return redirect()->route('Admin.Permissions.index')
            ->withSuccess(__('New Permission is added successfully'));
    }
    public function show($id)
    {
        $rolePermissions = $this->PermissionService->ShowById($id);
        return view('Admin.roles.show', [
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sections = $this->SectionService->getAll();
        $Permission =  $this->PermissionService->getById($id);
        return view('Admin.roles.permissions.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->PermissionService->update($id, $request->all());
        return redirect()->route('Admin.Permissions.index')
            ->withSuccess(__('Update successfully'));
    }


    public function destroy($id)
    {
        // return Permission::whereid($id)->first();
        $check =  DB::table('model_has_permissions')->where('permission_id', $id)->first();
        if ($check) {
            return back()->with('sorry', __('It could not be deleted because it is linked to a role'));
        } else {
            $this->PermissionService->delete($id);
            return redirect()->route('Admin.Permissions.index')
                ->withSuccess(__('deleted successfully'));
        }
    }
}
