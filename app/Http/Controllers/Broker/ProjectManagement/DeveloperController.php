<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Broker\DeveloperService;
use App\Services\RegionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class DeveloperController extends Controller
{
    protected $developerService;
    protected $regionService;
    protected $cityService;

    public function __construct(DeveloperService $developerService, RegionService $regionService, CityService $cityService)
    {
        $this->developerService = $developerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $brokerId = Auth::user()->UserBrokerData->id;
        $developers = $this->developerService->getAllDevelopersByBroker($brokerId);
       return view('Broker.ProjectManagement.Developer.index', get_defined_vars());
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Developer.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->developerService->createDeveloper($request->all());
        return redirect()->route('Broker.Developer.index')->with('success', __('added successfully'));
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $developer = $this->developerService->getDeveloperById($id);
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Developer.edit',get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->developerService->updateDeveloper($id, $request->all());
        return redirect()->route('Broker.Developer.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->developerService->deleteDeveloper($id);
        return redirect()->route('Broker.Developer.index')->with('success', __('Deleted successfully'));
    }
}
