<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\OwnerService;
use App\Services\RegionService;

class OwnerController extends Controller
{

    protected $OwnerService;
    protected $regionService;
    protected $cityService;

    public function __construct(OwnerService $OwnerService, RegionService $regionService, CityService $cityService)
    {
        $this->OwnerService = $OwnerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $owners = $this->OwnerService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Owner.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->OwnerService->createOwner($request->all());
        return redirect()->route('Office.Owner.index')->with('success', __('added successfully'));
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
        $Owner =  $this->OwnerService->getOwnerById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Owner.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->OwnerService->updateOwner($id, $request->all());
        return redirect()->route('Office.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->OwnerService->deleteOwner($id);
        return redirect()->route('Office.Owner.index')->with('success', __('Deleted successfully'));
    }
}