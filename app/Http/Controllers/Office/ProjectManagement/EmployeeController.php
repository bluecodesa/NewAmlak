<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\EmployeeService;
use App\Services\RegionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\PermissionService;
use App\Services\Admin\SectionService;
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
    public function store(Request $request)
    {

        $requestData = $request->only(['name', 'email', 'phone']);
        $roleId = $request->roles;
        $employeeData = [
            'office_id' => Auth::user()->UserOfficeData->id,
            'city_id' => $request->city_id
        ];
        $this->EmployeeService->create($requestData, $roleId, $employeeData);
        return redirect()->route('Office.Employee.index')->with('success', __('added successfully'));
    }


    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $Employee = $this->EmployeeService->find($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $roles =  $this->RoleService->getAllRoles();
        return view('Admin.ProjectManagement.Employee.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->only(['name', 'email', 'phone']);
        $roleId = $request->roles;
        $employeeData = [
            'office_id' => Auth::user()->UserOfficeData->id,
            'city_id' => $request->city_id
        ];
        $this->EmployeeService->update($id, $requestData, $roleId, $employeeData);
        return redirect()->route('Office.Employee.index')->with('success', __('Update successfully'));
    }


    public function destroy(string $id)
    {
        $this->EmployeeService->delete($id);
        return redirect()->route('Office.Employee.index')->with('success', __('Deleted successfully'));
    }
}
