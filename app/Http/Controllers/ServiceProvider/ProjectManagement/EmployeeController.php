<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeePermission;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\EmployeeService;
use App\Services\RegionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\PermissionService;
use App\Services\Admin\SectionService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    protected $EmployeeService;
    protected $regionService;
    protected $cityService;
    protected $RoleService;
    protected $PermissionService;
    protected $SectionService;

    public function __construct(EmployeeService $EmployeeService, RegionService $regionService,
     CityService $cityService, RoleService $RoleService,
     PermissionService $PermissionService, SectionService $SectionService)
    {
        $this->EmployeeService = $EmployeeService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->RoleService = $RoleService;
        $this->PermissionService = $PermissionService;
        $this->SectionService = $SectionService;
    }

    public function index()
    {
        $employees = $this->EmployeeService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Employee.index', get_defined_vars());
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $roles = $this->RoleService->getAllRoles();
        $role =   $this->RoleService->getById(18);
        $role_permissions =  $role->permissions->pluck('id')->toArray();;
        $permissions =  $this->PermissionService->getAll()->where('type', 'user');

        // Step 1: Retrieve Role IDs for 'Office-Admin'
        $roleIds = Role::where('name', 'Office-Admin')->pluck('id')->toArray();

        // Step 2: Retrieve permissions of type 'user' and filter by role IDs
        $permissions = Permission::where('type', 'user')
            ->whereIn('id', function ($query) use ($roleIds) {
                $query->select('permission_id')
                      ->from('role_has_permissions')
                      ->whereIn('role_id', $roleIds);
            })
            ->get();
        return view('Office.ProjectManagement.Employee.create', get_defined_vars());
    }
    // public function store(Request $request)
    // {

    //     $requestData = $request->only(['name', 'email', 'phone']);
    //     $roleId = $request->roles;
    //     $employeeData = [
    //         'office_id' => Auth::user()->UserOfficeData->id,
    //         'city_id' => $request->city_id
    //     ];
    //     $this->EmployeeService->create($requestData, $roleId, $employeeData);
    //     return redirect()->route('Office.Employee.index')->with('success', __('added successfully'));
    // }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:9|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'permissions' => 'required|array',
    ], [
        'name.required' => __('The name field is required.'),
        'name.string' => __('The name must be a string.'),
        'name.max' => __('The name may not be greater than :max characters.'),

        'email.required' => __('The email field is required.'),
        'email.string' => __('The email must be a string.'),
        'email.email' => __('The email must be a valid email address.'),
        'email.max' => __('The email may not be greater than :max characters.'),
        'email.unique' => __('The email has already been taken.'),

        'phone.required' => __('The phone field is required.'),
        'phone.string' => __('The phone must be a string.'),
        'phone.max' => __('The phone may not be greater than :max characters.'),
        'phone.unique' => __('The phone has already been taken.'),

        'password.required' => __('The password field is required.'),
        'password.string' => __('The password must be a string.'),
        'password.min' => __('The password must be at least :min characters.'),
        'password.confirmed' => __('The password confirmation does not match.'),

        'permissions.required' => __('At least one permission must be selected.'),
        'permissions.array' => __('Invalid permissions data.'),
    ]);

    $permissions = Permission::whereIn('id', $request['permissions'])->get();
    $officeId = auth()->user()->UserOfficeData->id;
    $office = Office::find($officeId);

    $currentEmployeeCount = Employee::where('office_id', $officeId)->count();

    if ($currentEmployeeCount >= $office->max_of_employee) {
        return redirect()->back()->with('success', __('The maximum number of employees for this office has been reached.'));
    }

    $user = User::create([
        'is_employee' => 1,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'key_phone' => $request->key_phone,
        'full_phone' => $request->full_phone,
        'password' => Hash::make($request->password),
    ]);

    $role = Role::firstOrCreate(['name' => 'Office-Employee']);
    $user->assignRole($role);

    $role->syncPermissions($permissions);

    $employee = Employee::create([
        'user_id' => $user->id,
        'office_id' => $officeId,
    ]);

    $user->syncPermissions($permissions);
    return redirect()->route('Office.Employee.index')->with('success', __('Employee added successfully.'));
}

   // $employeePermissions = [];
    // foreach ($request->permissions as $permissionId) {
    //     $employeePermissions[] = [
    //         'employee_id' => $employee->id,
    //         'permission_id' => $permissionId,
    //     ];
    // }

    // EmployeePermission::insert($employeePermissions);

    public function show($id)
    {
        $employee = Employee::with('userData')->findOrFail($id);
        $permissions = Permission::all();
        $employeePermissions = $employee->userData->permissions->pluck('id')->toArray();

        return view('Office.ProjectManagement.Employee.show', compact('employee', 'permissions', 'employeePermissions'));
    }
public function edit($id)
{
    $employee = $this->EmployeeService->find($id);
    $Regions = $this->regionService->getAllRegions();
    $cities = $this->cityService->getAllCities();
    $roles =  $this->RoleService->getAllRoles();

    $role = Role::where('name', 'Office-Employee')->first();
    $permissions = $role ? $role->permissions : collect();

    $employeePermissions = $employee->UserData->permissions->pluck('id')->toArray();
    $roleIds = Role::where('name', 'Office-Admin')->pluck('id')->toArray();

    $permissions = Permission::where('type', 'user')
        ->whereIn('id', function ($query) use ($roleIds) {
            $query->select('permission_id')
                  ->from('role_has_permissions')
                  ->whereIn('role_id', $roleIds);
        })
        ->get();
        return view('Office.ProjectManagement.Employee.edit', get_defined_vars());
    }



    // public function update(Request $request, $id)
    // {

    //     $requestData = $request->only(['name', 'email', 'phone']);
    //     $roleId = $request->roles;
    //     $employeeData = [
    //         'office_id' => Auth::user()->UserOfficeData->id,
    //         'city_id' => $request->city_id
    //     ];
    //     $this->EmployeeService->update($id, $requestData, $roleId, $employeeData);
    //     return redirect()->route('Office.Employee.index')->with('success', __('Update successfully'));
    // }


    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'phone' => [
                'required',
                'string',
                'max:25',
            ],
            'full_phone' => [
                'required',
                'string',
                'max:25',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'permissions' => 'required|array',
        ], [
            'name.required' => __('The name field is required.'),
            'name.string' => __('The name must be a string.'),
            'name.max' => __('The name may not be greater than :max characters.'),

            'email.required' => __('The email field is required.'),
            'email.string' => __('The email must be a string.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.max' => __('The email may not be greater than :max characters.'),
            'email.unique' => __('The email has already been taken.'),

            'phone.required' => __('The phone field is required.'),
            'phone.string' => __('The phone must be a string.'),
            'phone.max' => __('The phone may not be greater than :max characters.'),
            'phone.unique' => __('The phone has already been taken.'),

            'password.string' => __('The password must be a string.'),
            'password.min' => __('The password must be at least :min characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),

            'permissions.required' => __('At least one permission must be selected.'),
            'permissions.array' => __('Invalid permissions data.'),
        ]);

        $permissions = Permission::whereIn('id', $request['permissions'])->get();

        $user = $employee->userData;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
        ]);

        $role = Role::firstOrCreate(['name' => 'Office-Employee']);
        $user->syncPermissions($permissions);

        return redirect()->route('Office.Employee.index')->with('success', __('Employee updated successfully.'));
    }



    public function destroy(string $id)
    {
        $this->EmployeeService->delete($id);
        return redirect()->route('Office.Employee.index')->with('success', __('Deleted successfully'));
    }
}
