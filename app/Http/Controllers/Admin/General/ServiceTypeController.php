<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\ServiceTypeService;

class ServiceTypeController extends Controller
{
    protected $ServiceTypeService;
    public function __construct(ServiceTypeService $ServiceTypeService)
    {
        $this->ServiceTypeService = $ServiceTypeService;
    }
    public function index()
    {
        $types =  $this->ServiceTypeService->getAll();
        return view('Admin.settings.ProjectType.ServiceType.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.ServiceType.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->ServiceTypeService->create($request->all());
        return redirect()->route('Admin.ServiceType.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $ServiceType =  $this->ServiceTypeService->getById($id);
        return view('Admin.settings.ProjectType.ServiceType.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->ServiceTypeService->update($id, $request->all());
        return redirect()->route('Admin.ServiceType.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->ServiceTypeService->delete($id);
        return redirect()->route('Admin.ServiceType.index')->with('success', __('Deleted successfully'));
    }
}
