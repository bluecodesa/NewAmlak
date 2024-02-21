<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\PropertyUsageService;

class PropertyUsageController extends Controller
{
    protected $PropertyUsageService;
    public function __construct(PropertyUsageService $PropertyUsageService)
    {
        $this->PropertyUsageService = $PropertyUsageService;
    }
    public function index()
    {
        $types =  $this->PropertyUsageService->getAll();
        return view('Admin.settings.ProjectType.PropertyUsage.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.PropertyUsage.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->PropertyUsageService->create($request->all());
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('added successfully'));
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
        $PropertyUsage =  $this->PropertyUsageService->getById($id);
        return view('Admin.settings.ProjectType.PropertyUsage.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->PropertyUsageService->update($id, $request->all());
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->PropertyUsageService->delete($id);
        return redirect()->route('Admin.PropertyUsage.index')->with('success', __('Deleted successfully'));
    }
}
