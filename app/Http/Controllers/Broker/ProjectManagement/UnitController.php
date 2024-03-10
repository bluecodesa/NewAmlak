<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\UnitService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;


class UnitController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;


    public function __construct(UnitService $UnitService, RegionService $regionService, AllServiceService $AllServiceService, FeatureService $FeatureService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->UnitService = $UnitService;
        $this->brokerDataService = $brokerDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
    }

    public function index()
    {
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Project.Unit.index',  get_defined_vars());
    }

    public function create()
    {
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Broker.ProjectManagement.Project.Unit.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->UnitService->store($request->all());
        return redirect()->route('Broker.Unit.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $Unit = $this->UnitService->findById($id);
        return view('Broker.ProjectManagement.Project.Unit.show',  get_defined_vars());
    }

    public function edit($id)
    {
        $Unit = $this->UnitService->findById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Broker.ProjectManagement.Project.Unit.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->UnitService->update($id, $request->all());
        return redirect()->route('Broker.Unit.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->UnitService->delete($id);
        return redirect()->route('Broker.Unit.index')->with('success', __('Deleted successfully'));
    }
}
