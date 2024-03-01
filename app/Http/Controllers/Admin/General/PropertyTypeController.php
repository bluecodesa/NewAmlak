<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\PropertyTypeService;

class PropertyTypeController extends Controller
{
    protected $PropertyTypeService;
    public function __construct(PropertyTypeService $PropertyTypeService)
    {
        $this->PropertyTypeService = $PropertyTypeService;
    }

    public function index()
    {
        $types = $this->PropertyTypeService->getAll();
        return view('Admin.settings.ProjectType.PropertyType.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.ProjectType.PropertyType.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->PropertyTypeService->create($request->all());
        return redirect()->route('Admin.PropertyType.index')->with('success', __('added successfully'));
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
        $PropertyType = $this->PropertyTypeService->getById($id);
        return view('Admin.settings.ProjectType.PropertyType.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->PropertyTypeService->update($id, $request->all());
        return redirect()->route('Admin.PropertyType.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->PropertyTypeService->delete($id);
        return redirect()->route('Admin.PropertyType.index')->with('success', __('Deleted successfully'));
    }
}
