<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\Admin\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $ServiceService;
    public function __construct(ServiceService $ServiceService)
    {
        $this->ServiceService = $ServiceService;
        $this->middleware(['role_or_permission:read-real-estate-settings'])->only('index');
        $this->middleware(['role_or_permission:create-real-estate-settings'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-real-estate-settings'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-real-estate-settings'])->only(['destroy']);
    }

    public function index()
    {
        $services =  $this->ServiceService->getAll();
        return view('Admin.settings.ProjectType.Service.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.Service.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->ServiceService->create($request->all());
        return redirect()->route('Admin.Service.index')->with('success', __('added successfully'));
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
        $Service =  $this->ServiceService->getById($id);
        return view('Admin.settings.ProjectType.Service.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->ServiceService->update($id, $request->all());
        return redirect()->route('Admin.Service.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->ServiceService->delete($id);
        return redirect()->route('Admin.Service.index')->with('success', __('Deleted successfully'));
    }
}
