<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Broker\OwnerService;
use App\Services\RegionService;

class OwnerController extends Controller
{

    protected $ownerService;
    protected $regionService;
    protected $cityService;

    public function __construct(OwnerService $ownerService, RegionService $regionService, CityService $cityService)
    {
        $this->ownerService = $ownerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $owners = $this->ownerService->getAllByBrokerId(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Owner.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->ownerService->createOwner($request->all());
        return redirect()->route('Broker.Owner.index')->with('success', __('added successfully'));
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
        $Owner =  $this->ownerService->getOwnerById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Owner.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->ownerService->updateOwner($id, $request->all());
        return redirect()->route('Broker.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->ownerService->deleteOwner($id);
        return redirect()->route('Broker.Owner.index')->with('success', __('Deleted successfully'));
    }
}
