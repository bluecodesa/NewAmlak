<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Services\Admin\RegionService;

class RegionController extends Controller
{
    protected $regionService;
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
        $this->middleware(['role_or_permission:read-regions-cities-districts'])->only('index');
        $this->middleware(['role_or_permission:create-regions-cities-districts'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-regions-cities-districts'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-regions-cities-districts'])->only(['destroy']);
    }

    public function index()
    {
        $regions = $this->regionService->getAllRegions();
        return view('Admin.settings.Region.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.settings.Region.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->regionService->create($request->all());
        return redirect()->route('Admin.Region.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cities =    $this->regionService->getCityByRegionId($id);
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    public function edit($id)
    {
        $Region = $this->regionService->getRegionById($id);
        return view('Admin.settings.Region.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->regionService->update($id, $request->all());
        return redirect()->route('Admin.Region.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->regionService->delete($id);
        return redirect()->route('Admin.Region.index')->with('success', __('Deleted successfully'));
    }
}
