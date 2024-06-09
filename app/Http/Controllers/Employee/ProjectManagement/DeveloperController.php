<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Office\DeveloperService;
use App\Services\RegionService;
use Illuminate\Http\Request;
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
        $developers = $this->developerService->getAllDevelopersByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Developer.index', compact('developers'));
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Developer.create', compact('Regions', 'cities'));
    }

    public function store(Request $request)
    {
        $this->developerService->createDeveloper($request->all());
        return redirect()->route('Office.Developer.index')->with('success', __('added successfully'));
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $developer = $this->developerService->getDeveloperById($id);
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Developer.edit', compact('Regions', 'developer', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $this->developerService->updateDeveloper($id, $request->all());
        return redirect()->route('Office.Developer.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->developerService->deleteDeveloper($id);
        return redirect()->route('Office.Developer.index')->with('success', __('Deleted successfully'));
    }
}
