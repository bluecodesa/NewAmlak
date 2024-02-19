<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Office\AdvisorService;
use App\Services\RegionService;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    protected $advisorService;
    protected $regionService;
    protected $cityService;

    public function __construct(AdvisorService $advisorService, RegionService $regionService, CityService $cityService)
    {
        $this->advisorService = $advisorService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $advisors = $this->advisorService->getAllAdvisorsForOffice();
        return view('Office.ProjectManagement.Advisor.index', compact('advisors'));
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Advisor.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->advisorService->createAdvisor($request->all());
        return redirect()->route('Office.Advisor.index')->with('success', __('Added successfully'));
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisor = $this->advisorService->getAdvisorById($id);
        return view('Office.ProjectManagement.Advisor.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->advisorService->updateAdvisor($id, $request->all());
        return redirect()->route('Office.Advisor.index')->with('success', __('Updated successfully'));
    }

    public function destroy($id)
    {
        $this->advisorService->deleteAdvisor($id);
        return redirect()->route('Office.Advisor.index')->with('success', __('Deleted successfully'));
    }
}
