<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DistrictService;
use App\Services\CityService;

class DistrictController extends Controller
{
    protected $DistrictService;
    protected $CityService;
    public function __construct(DistrictService $DistrictService, CityService $CityService)
    {
        $this->DistrictService = $DistrictService;
        $this->CityService = $CityService;
        $this->middleware(['role_or_permission:read-regions-cities-districts'])->only('index');
        $this->middleware(['role_or_permission:create-regions-cities-districts'])->only(['store', 'create']);
        $this->middleware(['role_or_permission:update-regions-cities-districts'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-regions-cities-districts'])->only(['destroy']);
    }

    public function index()
    {
        $districts = $this->DistrictService->getAllDistrict();
        return view('Admin.settings.Region.City.District.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities =  $this->CityService->getAllCities();
        return view('Admin.settings.Region.City.District.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->DistrictService->create($request->all());
        return redirect()->route('Admin.District.index')->with('success', __('added successfully'));
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
        $cities =  $this->CityService->getAllCities();
        $District = $this->DistrictService->getDistrictById($id);
        return view('Admin.settings.Region.City.District.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->DistrictService->update($id, $request->all());
        return redirect()->route('Admin.District.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->DistrictService->delete($id);
        return redirect()->route('Admin.District.index')->with('success', __('Deleted successfully'));
    }
}
