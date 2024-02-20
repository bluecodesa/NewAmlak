<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\Broker\AdvisorService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\RegionService;
use App\Services\CityService;



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
        $advisors = $this->advisorService->getAllAdvisorsForBroker();
        return view('Broker.ProjectManagement.Advisor.index', get_defined_vars());
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Advisor.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->advisorService->createAdvisor($request->all());
        return redirect()->route('Broker.Advisor.index')->with('success', __('Added successfully'));
    }

    public function edit($id)
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisor = $this->advisorService->getAdvisorById($id);
        return view('Broker.ProjectManagement.Advisor.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->advisorService->updateAdvisor($id, $request->all());
        return redirect()->route('Broker.Advisor.index')->with('success', __('Updated successfully'));
    }

    public function destroy($id)
    {
        $this->advisorService->deleteAdvisor($id);
        return redirect()->route('Broker.Advisor.index')->with('success', __('Deleted successfully'));
    }
}

