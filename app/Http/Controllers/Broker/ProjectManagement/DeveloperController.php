<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\RegionService;
use App\Models\City;
use App\Services\Broker\DeveloperService;
use App\Services\CityService;
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
        $developers = $this->developerService->getAllDevelopersByBrokerId(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Developer.index', compact('developers'));
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Developer.create', compact('Regions', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers')->ignore($request->id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('developers')->ignore($request->id),
                'max:25'
            ],
        ]);

        $this->developerService->createDeveloper($request->all());

        return redirect()->route('Broker.Developer.index')->with('success', __('added successfully'));
    }

    public function show(string $id)
    {
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $developer = $this->developerService->getDeveloperById($id);
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Developer.edit', compact('Regions', 'developer', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers')->ignore($id),
                'max:255'
            ],
            'phone' => [
                'required',
                Rule::unique('developers')->ignore($id),
                'max:25'
            ],
        ]);

        $this->developerService->updateDeveloper($id, $request->all());

        return redirect()->route('Broker.Developer.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->developerService->deleteDeveloper($id);

        return redirect()->route('Broker.Developer.index')->with('success', __('Deleted successfully'));
    }
}
