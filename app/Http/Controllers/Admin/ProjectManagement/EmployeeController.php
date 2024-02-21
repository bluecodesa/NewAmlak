<?php

namespace App\Http\Controllers\Admin\ProjectManagement;

use App\Http\Controllers\Controller;

use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    protected $EmployeeService;

    public function __construct(EmployeeService $EmployeeService)
    {
        $this->EmployeeService = $EmployeeService;
    }

    public function index()
    {
        $employees =  $this->EmployeeService->getAll();
        return view('Admin.ProjectManagement.Employee.index', get_defined_vars());
    }

    public function destroy(string $id)
    {
        $this->EmployeeService->Delete($id);
        return redirect()->route('Admin.Employee.index')->with('success', __('Deleted successfully'));
    }
}
