<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\CityService;
use App\Services\RegionService;

class CityController extends Controller
{

    protected $CityService;
    protected $regionService;
    protected $cityService;

    public function __construct(CityService $CityService, RegionService $regionService)
    {
        $this->CityService = $CityService;
        $this->regionService = $regionService;

        $this->middleware(['role_or_permission:read-regions-cities-districts'])->only('index');
        $this->middleware(['role_or_permission:create-regions-cities-districts'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-regions-cities-districts'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-regions-cities-districts'])->only(['destroy']);
    }

    public function index()
    {
        $Cities = $this->CityService->getAllCities();
        return view('Admin.settings.Region.City.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        return view('Admin.settings.Region.City.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->CityService->create($request->all());
        return redirect()->route('Admin.City.index')->with('success', __('added successfully'));
    }
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $City =  $this->CityService->getCityById($id);
        return view('Admin.settings.Region.City.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->CityService->updateCity($id, $request->all());
        return redirect()->route('Admin.City.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->CityService->delete($id);
        return redirect()->route('Admin.City.index')->with('success', __('Deleted successfully'));
    }
}